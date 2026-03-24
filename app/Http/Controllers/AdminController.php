<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\User;
use App\Models\MedicalExamination;
use App\Models\PatientProfile;
use App\Models\Prescription;
use App\Models\Setting;
use App\Services\WhatsAppNotifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    public function __construct(private readonly WhatsAppNotifier $whatsAppNotifier)
    {
    }

    private const FARMASI_SERVICE = 'Lintas Klaster - Farmasi/Apotek';

    private const DISPLAY_VIDEO_KEY = 'display_local_videos';
    private const DISPLAY_VIDEO_ORDER_KEY = 'display_local_video_order';
    private const DISPLAY_VIDEO_SLOTS = 5;

    private const CLUSTER_LABELS = [
        1 => 'Klaster 1',
        2 => 'Klaster 2',
        3 => 'Klaster 3',
        4 => 'Klaster 4',
        5 => 'Klaster 5',
    ];

    public function index(): View
    {
        $today = now()->toDateString();
        $activeSection = request()->query('section', 'dashboard');

        if ($activeSection === 'scan-qr') {
            redirect()->route('admin.dashboard', ['section' => 'dashboard'])->send();
            exit;
        }

        $allowedSections = [
            'dashboard',
            'laporan-antrian',
            'statistik-ringkas',
            'klaster-keluhan',
            'akun-pasien',
            'persetujuan-antrian',
            'menunggu-scan',
            'ringkasan-antrian',
        ];

        if (!in_array($activeSection, $allowedSections, true)) {
            $activeSection = 'dashboard';
        }

        $pendingUsers = User::where('status', 'pending')->whereIn('role', ['patient', 'pasien'])->get();
        $pendingQueueApprovals = Queue::where('status', 'pending')->latest()->get();
        $waiting = Queue::where('status', 'waiting')
            ->whereDate('queue_date', $today)
            ->arrivalOrder()
            ->get();
        $served = Queue::where('status', 'served')
            ->whereDate('updated_at', $today)
            ->latest('updated_at')
            ->get();
        $servedAllCount = Queue::where('status', 'served')->count();
        
        // Antrian yang sudah daftar tapi belum scan (menunggu kedatangan)
        $approvedQueues = Queue::where('status', 'approved')
            ->whereDate('queue_date', $today)
            ->orderBy('created_at')
            ->get();

        $staleApprovedQueues = Queue::where('status', 'approved')
            ->whereDate('queue_date', '<', $today)
            ->orderBy('queue_date')
            ->orderBy('created_at')
            ->get();

        $userStats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_patients' => User::whereIn('role', ['patient', 'pasien'])->count(),
            'approved_patients' => User::whereIn('role', ['patient', 'pasien'])->where('status', 'approved')->count(),
            'pending_patients' => User::whereIn('role', ['patient', 'pasien'])->where('status', 'pending')->count(),
        ];

        $todayQueueCount = Queue::whereDate('created_at', $today)->count();

        $clusterSummary = Queue::select('service_type')
            ->selectRaw('COUNT(*) as total')
            ->whereDate('created_at', $today)
            ->groupBy('service_type')
            ->orderByDesc('total')
            ->get();

        $todayComplaints = Queue::whereDate('created_at', $today)
            ->whereNotNull('complaint')
            ->where('complaint', '!=', '')
            ->latest()
            ->limit(10)
            ->get(['queue_number', 'patient_name', 'service_type', 'complaint', 'created_at']);

        $patientAccounts = User::whereIn('role', ['patient', 'pasien'])
            ->latest()
            ->get(['id', 'name', 'email', 'status', 'verified_at', 'created_at']);
        $manualServices = array_keys(Queue::SERVICE_PREFIXES);
        
        return view('admin.dashboard', compact(
            'activeSection',
            'pendingUsers',
            'pendingQueueApprovals',
            'waiting',
            'served',
            'servedAllCount',
            'approvedQueues',
            'staleApprovedQueues',
            'userStats',
            'todayQueueCount',
            'clusterSummary',
            'todayComplaints',
            'patientAccounts',
            'manualServices'
        ));
    }

    /**
     * Approve user registration
     */
    public function approveUser(User $user): RedirectResponse
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User tidak dalam status pending.');
        }

        $user->update([
            'status' => 'approved',
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Akun {$user->name} telah diverifikasi!");
    }

    /**
     * Reject user registration
     */
    public function rejectUser(User $user): RedirectResponse
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User tidak dalam status pending.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', "Akun {$userName} telah ditolak dan dihapus.");
    }

    public function callNext()
    {
        $queue = Queue::where('status', 'waiting')
            ->arrivalOrder()
            ->first();

        if($queue){
            $queue->update([
                'status' => 'called',
                'called_at' => now(),
                'called_by_role' => 'admin',
            ]);

            $this->whatsAppNotifier->sendQueueCalledNotification($queue);
        }
        return redirect()->back();
    }

    public function markServed($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->update(['status'=>'served']);

        if ($queue->service_type === self::FARMASI_SERVICE) {
            Prescription::where('user_id', $queue->user_id)
                ->whereIn('status', ['menunggu', 'disiapkan'])
                ->update([
                    'status' => 'diambil',
                    'waktu_diambil' => now(),
                ]);
        }

        return redirect()->back();
    }

    public function destroyStuckQueue(Queue $queue): RedirectResponse
    {
        if ($queue->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya antrian approved yang bisa dibersihkan dari loket.');
        }

        if (!$queue->queue_date || $queue->queue_date->toDateString() >= now()->toDateString()) {
            return redirect()->back()->with('error', 'Antrian hari ini tidak dapat dihapus dari menu antrian kadaluarsa.');
        }

        $queueLabel = $queue->queue_number ?: $queue->patient_name;
        $queue->delete();

        return redirect()->back()->with('success', "Antrian kadaluarsa {$queueLabel} berhasil dihapus.");
    }

    public function markAllWaitingServed(): RedirectResponse
    {
        $waitingQueues = Queue::where('status', 'waiting')->get();
        $updated = $waitingQueues->count();

        if ($updated > 0) {
            Queue::whereIn('id', $waitingQueues->pluck('id'))
                ->update(['status' => 'served']);

            $farmasiUserIds = $waitingQueues
                ->where('service_type', self::FARMASI_SERVICE)
                ->pluck('user_id')
                ->filter()
                ->unique()
                ->values();

            if ($farmasiUserIds->isNotEmpty()) {
                Prescription::whereIn('user_id', $farmasiUserIds)
                    ->whereIn('status', ['menunggu', 'disiapkan'])
                    ->update([
                        'status' => 'diambil',
                        'waktu_diambil' => now(),
                    ]);
            }
        }

        if ($updated === 0) {
            return redirect()->back()->with('info', 'Tidak ada antrian menunggu untuk diselesaikan.');
        }

        return redirect()->back()->with('success', "{$updated} antrian menunggu berhasil ditandai selesai.");
    }

    public function waiting()
    {
        $waiting = Queue::where('status', 'waiting')
            ->arrivalOrder()
            ->get();
        return view('admin.waiting', compact('waiting'));
    }

    public function served()
    {
        $served = Queue::where('status','served')->latest()->get();
        return view('admin.served', compact('served'));
    }

    public function downloadQueueReport(Request $request): BinaryFileResponse
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = !empty($validated['start_date'])
            ? Carbon::parse($validated['start_date'])->startOfDay()
            : now()->startOfMonth();
        $endDate = !empty($validated['end_date'])
            ? Carbon::parse($validated['end_date'])->endOfDay()
            : now()->endOfDay();

        $queues = Queue::with(['user.profile'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        $dailyTotals = Queue::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total_pasien')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        $spreadsheet = new Spreadsheet();

        $detailSheet = $spreadsheet->getActiveSheet();
        $detailSheet->setTitle('Laporan Antrian');
        $detailSheet->fromArray([
            'Tanggal Kunjungan',
            'Klaster',
            'Poli/Layanan',
            'Nomor Antrian',
            'Nama Pasien',
            'NIK',
            'Jenis Kelamin',
            'No HP',
            'Waktu Tunggu',
            'Status Layanan',
        ], null, 'A1');

        $row = 2;
        foreach ($queues as $queue) {
            $createdAt = $queue->token_scanned_at ?? $queue->created_at;
            $endWait = $queue->called_at ?? now();
            $seconds = $createdAt ? max(0, $createdAt->diffInSeconds($endWait)) : 0;
            $minutes = (int) floor($seconds / 60);
            $remainingSeconds = $seconds % 60;
            $waitDuration = $minutes . ' menit ' . round($remainingSeconds) . ' detik';
            $clusterNumber = method_exists($queue, 'clusterNumber') ? $queue->clusterNumber() : null;
            $clusterLabel = $clusterNumber ? (self::CLUSTER_LABELS[$clusterNumber] ?? 'Klaster ' . $clusterNumber) : '-';
            $profile = $queue->user?->profile;
            $genderRaw = (string) ($profile->jenis_kelamin ?? '');
            $genderLabel = match ($genderRaw) {
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
                default => '-',
            };

            $detailSheet->fromArray([
                optional($queue->queue_date ?? $queue->created_at)->format('Y-m-d'),
                $clusterLabel,
                $queue->service_type,
                $queue->queue_number,
                $queue->patient_name,
                $queue->nik ?? ($profile->nik ?? '-'),
                $genderLabel,
                $profile->no_hp ?? $profile->no_telepon ?? '-',
                $waitDuration,
                Str::title(str_replace('_', ' ', (string) $queue->status)),
            ], null, 'A' . $row);

            $row++;
        }

        foreach (range('A', 'J') as $column) {
            $detailSheet->getColumnDimension($column)->setAutoSize(true);
        }

        $calendarSheet = $spreadsheet->createSheet();
        $calendarSheet->setTitle('Rekap Kalender Harian');
        $calendarSheet->fromArray([
            'Tanggal',
            'Total Pasien',
        ], null, 'A1');

        $row = 2;
        foreach ($dailyTotals as $item) {
            $calendarSheet->fromArray([
                $item->tanggal,
                (int) $item->total_pasien,
            ], null, 'A' . $row);
            $row++;
        }

        foreach (range('A', 'B') as $column) {
            $calendarSheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = 'laporan-antrian-' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.xlsx';
        $tempPath = storage_path('app/' . $filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    public function scanTicket(Request $request, Queue $queue): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        if ($queue->status === 'pending') {
            return redirect()->route('admin.dashboard')->with('error', 'Pengajuan antrian ini belum disetujui. Silakan perbolehkan dulu di menu persetujuan antrian.');
        }

        if ($queue->status === 'rejected') {
            return redirect()->route('admin.dashboard')->with('error', 'Pengajuan antrian ini ditolak dan tidak dapat diproses.');
        }

        if ($queue->status === 'waiting') {
            $queueLabel = $queue->queue_number ?: $queue->patient_name;

            return redirect()->route('admin.dashboard')->with('info', 'Pasien sudah ada di antrian menunggu: ' . $queueLabel);
        }

        if ($queue->status === 'called' || $queue->status === 'served') {
            return redirect()->route('admin.dashboard')->with('error', 'Antrian ini sudah diproses sebelumnya.');
        }

        if ($queue->token_scanned_at || !$queue->token) {
            return redirect()->route('admin.dashboard')->with('error', 'QR sudah digunakan.');
        }

        if ($request->token !== $queue->token) {
            return redirect()->route('admin.dashboard')->with('error', 'Token QR tidak valid.');
        }

        // Cek apakah tanggal antrian sesuai hari ini
        if ($queue->queue_date && !now()->isSameDay($queue->queue_date)) {
            return redirect()->route('admin.dashboard')->with('error', 'Tiket ini untuk tanggal ' . $queue->queue_date->format('d-m-Y') . ', bukan untuk hari ini.');
        }

        // Tiket berlaku 24 jam dari pembuatan
        if ($queue->created_at && now()->greaterThan($queue->created_at->copy()->addHours(24))) {
            return redirect()->route('admin.dashboard')->with('error', 'QR sudah kedaluwarsa (lebih dari 24 jam).');
        }

        $queueNumber = $queue->queue_number ?: Queue::generateNextQueueNumber($queue->service_type, $queue->queue_date);

        $queue->update([
            'queue_number' => $queueNumber,
            'token_scanned_at' => now(),
            'token' => null,
            'status' => 'waiting',
        ]);

        if ($queue->qr_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($queue->qr_path);
            $queue->update(['qr_path' => null]);
        }

        return redirect()->route('admin.dashboard')->with('success', "✓ Pasien {$queue->patient_name} ({$queueNumber}) berhasil masuk antrian menunggu.");
    }

    public function approveQueue(Queue $queue): RedirectResponse
    {
        if ($queue->status !== 'pending') {
            return redirect()->route('admin.dashboard')->with('error', 'Pengajuan antrian ini tidak dalam status pending.');
        }

        $queue->update(['status' => 'approved']);

        return redirect()->route('admin.dashboard')->with('success', "Pengajuan antrian {$queue->patient_name} disetujui. Nomor akan diberikan saat scan di loket.");
    }

    public function rejectQueue(Queue $queue): RedirectResponse
    {
        if ($queue->status !== 'pending') {
            return redirect()->route('admin.dashboard')->with('error', 'Pengajuan antrian ini tidak dalam status pending.');
        }

        $queue->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard')->with('success', "Pengajuan antrian {$queue->patient_name} ditolak.");
    }

    public function storeManualQueue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'service_type' => ['required', 'string', Rule::in(array_keys(Queue::SERVICE_PREFIXES))],
            'complaint' => ['nullable', 'string'],
            'has_bpjs' => ['nullable', 'boolean'],
        ]);

        $queueNumber = Queue::generateNextQueueNumber($validated['service_type']);

        Queue::create([
            'user_id' => null,
            'queue_number' => $queueNumber,
            'patient_name' => $validated['patient_name'],
            'nik' => $validated['nik'],
            'complaint' => $validated['complaint'] ?? null,
            'service_type' => $validated['service_type'],
            'queue_date' => now()->toDateString(),
            'status' => 'waiting',
            'token_scanned_at' => now(),
            'has_bpjs' => (bool) ($validated['has_bpjs'] ?? false),
        ]);

        return redirect()->back()->with('success', "Pendaftaran manual berhasil ditambahkan. Nomor antrian {$queueNumber} sudah masuk ke antrean menunggu.");
    }

    /**
     * Daftar pasien dengan search
     */
    public function patients(Request $request): View
    {
        $search = $request->input('search');

        $patients = User::whereIn('role', ['patient', 'pasien'])
            ->with('profile')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('profile', function ($pq) use ($search) {
                          $pq->where('nik', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.patients', compact('patients', 'search'));
    }

    /**
     * Lihat profil pasien
     */
    public function showPatientProfile(User $user): View
    {
        // Pastikan hanya pasien yang bisa dilihat
        if (!in_array($user->role, ['patient', 'pasien'])) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $latestServedPharmacyAt = Queue::where('user_id', $user->id)
            ->where('service_type', self::FARMASI_SERVICE)
            ->where('status', 'served')
            ->max('updated_at');

        if ($latestServedPharmacyAt) {
            Prescription::where('user_id', $user->id)
                ->whereIn('status', ['menunggu', 'disiapkan'])
                ->where('created_at', '<=', $latestServedPharmacyAt)
                ->update([
                    'status' => 'diambil',
                    'waktu_diambil' => now(),
                ]);
        }

        $profile = $user->profile;
        $queues = Queue::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $examinations = MedicalExamination::where('user_id', $user->id)
            ->orderBy('tanggal_periksa', 'desc')
            ->limit(10)
            ->get();

        $prescriptions = Prescription::where('user_id', $user->id)
            ->with('medicalExamination')
            ->orderByRaw('COALESCE(tanggal_resep, DATE(created_at)) DESC')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.patient-profile', compact('user', 'profile', 'queues', 'examinations', 'prescriptions'));
    }

    public function updatePatientProfilePhoto(Request $request, User $user): RedirectResponse
    {
        if (!in_array($user->role, ['patient', 'pasien'], true)) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $validated = $request->validate([
            'profile_photo' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $profile = $user->profile;
        if (!$profile) {
            $profile = PatientProfile::create(['user_id' => $user->id]);
        }

        if (!empty($profile->profile_photo_path)) {
            Storage::disk('public')->delete($profile->profile_photo_path);
        }

        $path = $request->file('profile_photo')->store('patient-documents/profile-photo', 'public');
        $profile->update([
            'profile_photo_path' => $path,
        ]);

        return redirect()->route('admin.patient.profile', $user)->with('success', 'Foto profil pasien berhasil diperbarui.');
    }

    public function deletePatientProfilePhoto(User $user): RedirectResponse
    {
        if (!in_array($user->role, ['patient', 'pasien'], true)) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $profile = $user->profile;

        if (!$profile || empty($profile->profile_photo_path)) {
            return redirect()->route('admin.patient.profile', $user)->with('error', 'Foto profil pasien belum tersedia.');
        }

        Storage::disk('public')->delete($profile->profile_photo_path);
        $profile->update([
            'profile_photo_path' => null,
        ]);

        return redirect()->route('admin.patient.profile', $user)->with('success', 'Foto profil pasien berhasil dihapus.');
    }

    /**
     * Kelola akun petugas klaster
     */
    public function petugas(Request $request): View
    {
        $search = $request->input('search');
        $cluster = $request->input('cluster');

        $petugas = User::query()
            ->where('role', 'petugas')
            ->when($cluster, function ($query, $cluster) {
                $query->where('cluster_number', (int) $cluster);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.petugas', [
            'petugas' => $petugas,
            'search' => $search,
            'selectedCluster' => $cluster,
        ]);
    }

    public function storePetugas(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'cluster_number' => ['required', 'integer', 'in:1,2,3,4,5'],
            'status' => ['required', 'in:approved,pending'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'petugas',
            'cluster_number' => (int) $validated['cluster_number'],
            'status' => $validated['status'],
            'verified_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        return redirect()->route('admin.petugas')->with('success', 'Akun petugas berhasil dibuat.');
    }

    public function updatePetugas(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'petugas') {
            return redirect()->route('admin.petugas')->with('error', 'User bukan petugas.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'cluster_number' => ['required', 'integer', 'in:1,2,3,4,5'],
            'status' => ['required', 'in:approved,pending'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cluster_number' => (int) $validated['cluster_number'],
            'status' => $validated['status'],
            'verified_at' => $validated['status'] === 'approved' ? ($user->verified_at ?? now()) : null,
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = $validated['password'];
        }

        $user->update($payload);

        return redirect()->route('admin.petugas')->with('success', 'Akun petugas berhasil diperbarui.');
    }

    public function deactivatePetugas(User $user): RedirectResponse
    {
        if ($user->role !== 'petugas') {
            return redirect()->route('admin.petugas')->with('error', 'User bukan petugas.');
        }

        $user->update([
            'status' => 'pending',
            'verified_at' => null,
        ]);

        return redirect()->route('admin.petugas')->with('success', 'Akun petugas berhasil dinonaktifkan.');
    }

    public function destroyPetugas(User $user): RedirectResponse
    {
        if ($user->role !== 'petugas') {
            return redirect()->route('admin.petugas')->with('error', 'User bukan petugas.');
        }

        $user->delete();

        return redirect()->route('admin.petugas')->with('success', 'Akun petugas berhasil dihapus.');
    }

    /**
     * Halaman settings
     */
    public function settings(): View
    {
        $videoPaths = $this->getDisplayVideoPaths();
        $videoOrder = $this->getDisplayVideoOrder();
        $videoUrls = array_map(function (string $path): string {
            return $path !== '' ? asset('storage/' . $path) : '';
        }, $videoPaths);

        $orderedSlots = array_map(function (int $slotNumber) use ($videoPaths, $videoUrls): array {
            $index = $slotNumber - 1;
            return [
                'slot' => $slotNumber,
                'index' => $index,
                'path' => $videoPaths[$index] ?? '',
                'url' => $videoUrls[$index] ?? '',
            ];
        }, $videoOrder);

        $waSettings = [
            'enabled' => filter_var(Setting::getValue('wa_enabled', false), FILTER_VALIDATE_BOOLEAN),
            'endpoint' => (string) Setting::getValue('wa_endpoint', ''),
            'token' => (string) Setting::getValue('wa_token', ''),
            'sender' => (string) Setting::getValue('wa_sender', 'Puskesmas'),
            'template' => (string) Setting::getValue(
                'wa_template',
                'Halo {name}, nomor antrian {queue_number} sedang dipanggil ke {service_type}. Silakan segera menuju lokasi layanan.'
            ),
        ];

        return view('admin.settings', compact('videoPaths', 'videoUrls', 'videoOrder', 'orderedSlots', 'waSettings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'remove_slot' => ['nullable', 'integer', 'in:1,2,3,4,5'],
            'slot_order' => ['nullable', 'string'],
            'video_files' => ['nullable', 'array'],
            'video_files.*' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime,video/x-msvideo,video/x-matroska,video/mpeg',
                'max:102400',
            ],
            'wa_enabled' => ['nullable', 'boolean'],
            'wa_endpoint' => ['nullable', 'url', 'max:500'],
            'wa_token' => ['nullable', 'string', 'max:255'],
            'wa_sender' => ['nullable', 'string', 'max:100'],
            'wa_template' => ['nullable', 'string', 'max:1000'],
        ]);

        $videoPaths = $this->getDisplayVideoPaths();
        $videoOrder = $this->normalizeDisplayVideoOrder($request->input('slot_order'));

        $removeSlot = (int) ($request->input('remove_slot') ?? 0);
        if ($removeSlot >= 1 && $removeSlot <= self::DISPLAY_VIDEO_SLOTS) {
            $removeIndex = $removeSlot - 1;
            $oldPath = $videoPaths[$removeIndex] ?? '';
            if ($oldPath !== '' && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $videoPaths[$removeIndex] = '';
        }

        for ($i = 0; $i < self::DISPLAY_VIDEO_SLOTS; $i++) {
            if (!$request->hasFile('video_files.' . $i)) {
                continue;
            }

            $uploadedFile = $request->file('video_files.' . $i);
            if (!$uploadedFile) {
                continue;
            }

            $oldPath = $videoPaths[$i] ?? '';
            if ($oldPath !== '' && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $filename = 'slot_' . ($i + 1) . '_' . now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $uploadedFile->getClientOriginalExtension();
            $newPath = $uploadedFile->storeAs('display_videos', $filename, 'public');
            $videoPaths[$i] = $newPath;
        }

        Setting::setValue(self::DISPLAY_VIDEO_KEY, json_encode($videoPaths));
        Setting::setValue(self::DISPLAY_VIDEO_ORDER_KEY, json_encode($videoOrder));

        Setting::setValue('wa_enabled', $request->boolean('wa_enabled') ? '1' : '0');
        Setting::setValue('wa_endpoint', trim((string) $request->input('wa_endpoint', '')));
        Setting::setValue('wa_token', trim((string) $request->input('wa_token', '')));
        Setting::setValue('wa_sender', trim((string) $request->input('wa_sender', 'Puskesmas')));
        Setting::setValue(
            'wa_template',
            trim((string) $request->input('wa_template', 'Halo {name}, nomor antrian {queue_number} sedang dipanggil ke {service_type}. Silakan segera menuju lokasi layanan.'))
        );

        return redirect()->route('admin.settings')->with('success', 'Pengaturan display dan notifikasi WhatsApp berhasil diperbarui.');
    }

    public function removeDisplayVideo(int $slot): RedirectResponse
    {
        if ($slot < 1 || $slot > self::DISPLAY_VIDEO_SLOTS) {
            return redirect()->route('admin.settings')->with('error', 'Slot video tidak valid.');
        }

        $index = $slot - 1;
        $videoPaths = $this->getDisplayVideoPaths();
        $path = $videoPaths[$index] ?? '';

        if ($path !== '' && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $videoPaths[$index] = '';
        Setting::setValue(self::DISPLAY_VIDEO_KEY, json_encode($videoPaths));

        return redirect()->route('admin.settings')->with('success', 'Video pada slot ' . $slot . ' berhasil dihapus.');
    }

    private function getDisplayVideoPaths(): array
    {
        $json = Setting::getValue(self::DISPLAY_VIDEO_KEY, '[]');
        $paths = json_decode((string) $json, true);
        if (!is_array($paths)) {
            $paths = [];
        }

        $normalized = [];
        for ($i = 0; $i < self::DISPLAY_VIDEO_SLOTS; $i++) {
            $value = $paths[$i] ?? '';
            $normalized[] = is_string($value) ? $value : '';
        }

        return $normalized;
    }

    private function getDisplayVideoOrder(): array
    {
        $json = Setting::getValue(self::DISPLAY_VIDEO_ORDER_KEY, '[]');
        $decoded = json_decode((string) $json, true);

        return $this->normalizeDisplayVideoOrder($decoded);
    }

    private function normalizeDisplayVideoOrder($rawOrder): array
    {
        $order = [];

        if (is_string($rawOrder) && $rawOrder !== '') {
            $decoded = json_decode($rawOrder, true);
            if (is_array($decoded)) {
                $rawOrder = $decoded;
            }
        }

        if (is_array($rawOrder)) {
            foreach ($rawOrder as $slot) {
                $slotNumber = (int) $slot;
                if ($slotNumber >= 1 && $slotNumber <= self::DISPLAY_VIDEO_SLOTS && !in_array($slotNumber, $order, true)) {
                    $order[] = $slotNumber;
                }
            }
        }

        for ($slot = 1; $slot <= self::DISPLAY_VIDEO_SLOTS; $slot++) {
            if (!in_array($slot, $order, true)) {
                $order[] = $slot;
            }
        }

        return $order;
    }

    /**
     * Convert YouTube URL to embed format
     */
    private function convertYoutubeToEmbed(?string $url): string
    {
        if (!$url) return '';

        $videoId = '';

        // Format: youtube.com/watch?v=VIDEO_ID (with any query order)
        if (preg_match('/(?:youtube\.com\/watch\?.*?[&?]v=)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: youtu.be/VIDEO_ID
        elseif (preg_match('/(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: youtube.com/embed/VIDEO_ID
        elseif (preg_match('/(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: youtube.com/live/VIDEO_ID
        elseif (preg_match('/(?:youtube\.com\/live\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format: youtube.com/shorts/VIDEO_ID
        elseif (preg_match('/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&loop=1&playlist={$videoId}";
        }

        return '';
    }
}