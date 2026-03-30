<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppQueueNotifier;
use App\Models\Queue;
use App\Models\User;
use App\Models\MedicalExamination;
use App\Models\PatientProfile;
use App\Models\Prescription;
use App\Models\Setting;
use App\Models\WhatsAppNotificationLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    public function __construct(private readonly WhatsAppQueueNotifier $whatsAppQueueNotifier)
    {
    }

    private const FARMASI_SERVICE = 'Lintas Klaster - Farmasi/Apotek';

    private const DISPLAY_VIDEO_KEY = 'display_local_videos';
    private const DISPLAY_VIDEO_ORDER_KEY = 'display_local_video_order';
    private const DISPLAY_VIDEO_SLOTS = 5;

    private const WHATSAPP_SETTING_DEFINITIONS = [
        'whatsapp_api_enabled' => [
            'label' => 'Aktifkan WhatsApp API',
            'description' => 'Menghidupkan atau mematikan pengiriman notifikasi WA.',
            'type' => 'boolean',
        ],
        'whatsapp_api_timeout' => [
            'label' => 'Timeout Request (detik)',
            'description' => 'Batas waktu request API sebelum dianggap gagal.',
            'type' => 'integer',
        ],
        'whatsapp_primary_type' => [
            'label' => 'Provider Primary Type',
            'description' => 'Tipe provider utama (contoh: fonnte atau generic).',
            'type' => 'text',
        ],
        'whatsapp_primary_enabled' => [
            'label' => 'Provider Primary Aktif',
            'description' => 'Status aktif provider utama.',
            'type' => 'boolean',
        ],
        'whatsapp_primary_endpoint' => [
            'label' => 'Primary Endpoint',
            'description' => 'URL endpoint API provider utama.',
            'type' => 'text',
        ],
        'whatsapp_primary_token' => [
            'label' => 'Primary Token',
            'description' => 'Token API provider utama.',
            'type' => 'password',
        ],
        'whatsapp_primary_retries' => [
            'label' => 'Primary Retry',
            'description' => 'Jumlah retry saat provider utama gagal.',
            'type' => 'integer',
        ],
        'whatsapp_fallback_type' => [
            'label' => 'Provider Fallback Type',
            'description' => 'Tipe provider cadangan.',
            'type' => 'text',
        ],
        'whatsapp_fallback_enabled' => [
            'label' => 'Provider Fallback Aktif',
            'description' => 'Status aktif provider fallback.',
            'type' => 'boolean',
        ],
        'whatsapp_fallback_endpoint' => [
            'label' => 'Fallback Endpoint',
            'description' => 'URL endpoint API provider fallback.',
            'type' => 'text',
        ],
        'whatsapp_fallback_token' => [
            'label' => 'Fallback Token',
            'description' => 'Token API provider fallback.',
            'type' => 'password',
        ],
        'whatsapp_fallback_retries' => [
            'label' => 'Fallback Retry',
            'description' => 'Jumlah retry saat provider fallback gagal.',
            'type' => 'integer',
        ],
    ];

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
        $allowedSections = [
            'dashboard',
            'scan-qr',
            'wa-audit',
            'statistik-ringkas',
            'klaster-keluhan',
            'akun-pasien',
            'verifikasi-pasien',
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
            ->orderByRaw('COALESCE(token_scanned_at, created_at) asc')
            ->orderBy('id')
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

        $waNotificationLogs = WhatsAppNotificationLog::with(['queue:id,queue_number,patient_name,service_type'])
            ->latest('id')
            ->limit(20)
            ->get();
        
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
            'waNotificationLogs'
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
            ->whereDate('queue_date', now()->toDateString())
            ->orderByRaw('COALESCE(token_scanned_at, created_at) asc')
            ->orderBy('id')
            ->first();

        if($queue){
            $queue->update([
                'status' => 'called',
                'called_at' => now(),
                'called_by_role' => 'admin',
            ]);

            $this->whatsAppQueueNotifier->sendQueueEvent($queue->fresh(), 'called');
        }
        return redirect()->back();
    }

    public function markServed($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->update(['status'=>'served']);

        $this->whatsAppQueueNotifier->sendQueueEvent($queue->fresh(), 'served');

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

        $queueNumber = $queue->queue_number;
        $queue->delete();

        return redirect()->back()->with('success', "Antrian kadaluarsa {$queueNumber} berhasil dihapus.");
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
            ->orderByRaw('COALESCE(token_scanned_at, created_at) asc')
            ->orderBy('id')
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
            $createdAt = $queue->created_at;
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
            return redirect()->route('admin.dashboard')->with('info', 'Pasien sudah ada di antrian menunggu: ' . $queue->queue_number);
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

        // Scan berhasil: tetapkan nomor antrian sekarang (FIFO berdasarkan waktu scan).
        DB::transaction(function () use ($queue): void {
            $queue->refresh();

            $scannedAt = now();
            $queueNumber = $this->generateQueueNumberForService(
                (string) $queue->service_type,
                $queue->queue_date?->toDateString() ?? now()->toDateString()
            );

            $queue->update([
                'queue_number' => $queueNumber,
                'token_scanned_at' => $scannedAt,
                'token' => null,
                'status' => 'waiting',
            ]);
        });

        $queue->refresh();

        if ($queue->qr_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($queue->qr_path);
            $queue->update(['qr_path' => null]);
        }

        $this->whatsAppQueueNotifier->sendQueueEvent($queue->fresh(), 'waiting');

        return redirect()->route('admin.dashboard')->with('success', "✓ Pasien {$queue->patient_name} ({$queue->queue_number}) berhasil masuk antrian menunggu.");
    }

    private function generateQueueNumberForService(string $serviceType, string $queueDate): string
    {
        $prefixMap = [
            'Manajemen - Ruang TU' => 'M',
            'Manajemen - Ruang Keuangan' => 'M',
            'Ibu & Anak - Ruang KIA' => 'I',
            'Ibu & Anak - Ruang VK/Bersalin' => 'I',
            'Ibu & Anak - Ruangan Klaster 2 (Bayi/Balita/Remaja)' => 'I',
            'Ibu & Anak - Ruang Imunisasi' => 'I',
            'Usia Dewasa & Lansia - Ruangan Klaster 3 (Skrining PTM)' => 'D',
            'Klaster 4 - Poli Anggrek (Penyakit Menular)' => 'P',
            'Klaster 4 - Ruang TB' => 'P',
            'Klaster 4 - Ruang Kesling' => 'P',
            'Klaster 4 - Ruang Malaria' => 'P',
            'Lintas Klaster - Ruang UGD & Observasi' => 'L',
            'Lintas Klaster - Farmasi/Apotek' => 'L',
            'Lintas Klaster - Laboratorium' => 'L',
        ];

        $prefix = $prefixMap[$serviceType] ?? 'X';

        $lastQueue = Queue::query()
            ->where('service_type', $serviceType)
            ->whereDate('queue_date', $queueDate)
            ->whereNotNull('queue_number')
            ->lockForUpdate()
            ->orderBy('queue_number', 'desc')
            ->first();

        $lastNumber = 0;
        if ($lastQueue && is_string($lastQueue->queue_number) && preg_match('/(\d+)$/', $lastQueue->queue_number, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $next = $lastNumber + 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function approveQueue(Queue $queue): RedirectResponse
    {
        if ($queue->status !== 'pending') {
            return redirect()->route('admin.dashboard')->with('error', 'Pengajuan antrian ini tidak dalam status pending.');
        }

        $queue->update(['status' => 'waiting']);

        return redirect()->route('admin.dashboard')->with('success', "Pengajuan antrian {$queue->queue_number} disetujui.");
    }

    public function rejectQueue(Queue $queue): RedirectResponse
    {
        if ($queue->status !== 'pending') {
            return redirect()->route('admin.dashboard')->with('error', 'Pengajuan antrian ini tidak dalam status pending.');
        }

        $queue->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard')->with('success', "Pengajuan antrian {$queue->queue_number} ditolak.");
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

        $whatsAppSettings = $this->buildWhatsAppSettingRows();

        return view('admin.settings', compact('videoPaths', 'videoUrls', 'videoOrder', 'orderedSlots', 'whatsAppSettings'));
    }

    public function saveWhatsAppSetting(Request $request): RedirectResponse
    {
        $allowedKeys = array_keys(self::WHATSAPP_SETTING_DEFINITIONS);

        if ($request->has('settings') && is_array($request->input('settings'))) {
            $request->validate([
                'settings' => ['required', 'array'],
            ]);

            $settings = (array) $request->input('settings', []);
            foreach ($settings as $key => $value) {
                if (!in_array($key, $allowedKeys, true)) {
                    continue;
                }

                $definition = self::WHATSAPP_SETTING_DEFINITIONS[$key] ?? null;
                if (!$definition) {
                    continue;
                }

                $stringValue = is_scalar($value) ? trim((string) $value) : '';
                $type = (string) ($definition['type'] ?? 'text');

                if ($type === 'boolean' && !in_array($stringValue, ['0', '1'], true)) {
                    return redirect()->route('admin.settings')->with('error', 'Nilai boolean tidak valid pada: ' . $key);
                }

                if ($type === 'integer' && $stringValue !== '' && (!is_numeric($stringValue) || (int) $stringValue < 0)) {
                    return redirect()->route('admin.settings')->with('error', 'Nilai angka tidak valid pada: ' . $key);
                }

                Setting::setValue($key, $stringValue);
            }

            return redirect()->route('admin.settings')->with('success', 'Semua pengaturan WhatsApp berhasil disimpan.');
        }

        $validated = $request->validate([
            'key' => ['required', 'string', Rule::in($allowedKeys)],
            'value' => ['nullable', 'string', 'max:2000'],
        ]);

        $key = (string) $validated['key'];
        $definition = self::WHATSAPP_SETTING_DEFINITIONS[$key] ?? null;
        if (!$definition) {
            return redirect()->route('admin.settings')->with('error', 'Kunci pengaturan WhatsApp tidak valid.');
        }

        $value = (string) ($validated['value'] ?? '');
        $type = (string) ($definition['type'] ?? 'text');

        if ($type === 'boolean' && !in_array($value, ['0', '1'], true)) {
            return redirect()->route('admin.settings')->with('error', 'Nilai boolean harus 0 atau 1.');
        }

        if ($type === 'integer' && $value !== '' && (!is_numeric($value) || (int) $value < 0)) {
            return redirect()->route('admin.settings')->with('error', 'Nilai angka harus bilangan bulat positif atau nol.');
        }

        Setting::setValue($key, $value);

        return redirect()->route('admin.settings')->with('success', 'Pengaturan WhatsApp berhasil disimpan: ' . $key);
    }

    public function deleteWhatsAppSetting(string $key): RedirectResponse
    {
        $allowedKeys = array_keys(self::WHATSAPP_SETTING_DEFINITIONS);
        if (!in_array($key, $allowedKeys, true)) {
            return redirect()->route('admin.settings')->with('error', 'Kunci pengaturan WhatsApp tidak valid.');
        }

        Setting::query()->where('key', $key)->delete();

        return redirect()->route('admin.settings')->with('success', 'Override pengaturan WhatsApp berhasil dihapus: ' . $key);
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

        return redirect()->route('admin.settings')->with('success', 'Video display offline berhasil diperbarui.');
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

    private function buildWhatsAppSettingRows(): array
    {
        $definitions = self::WHATSAPP_SETTING_DEFINITIONS;
        $keys = array_keys($definitions);
        $savedValues = Setting::query()
            ->whereIn('key', $keys)
            ->pluck('value', 'key')
            ->all();

        $defaults = [
            'whatsapp_api_enabled' => config('services.whatsapp.enabled', false) ? '1' : '0',
            'whatsapp_api_timeout' => (string) config('services.whatsapp.timeout', 10),
            'whatsapp_primary_type' => (string) data_get(config('services.whatsapp.providers'), '0.type', 'fonnte'),
            'whatsapp_primary_enabled' => data_get(config('services.whatsapp.providers'), '0.enabled', true) ? '1' : '0',
            'whatsapp_primary_endpoint' => (string) data_get(config('services.whatsapp.providers'), '0.endpoint', ''),
            'whatsapp_primary_token' => (string) data_get(config('services.whatsapp.providers'), '0.token', ''),
            'whatsapp_primary_retries' => (string) data_get(config('services.whatsapp.providers'), '0.max_retries', 2),
            'whatsapp_fallback_type' => (string) data_get(config('services.whatsapp.providers'), '1.type', 'generic'),
            'whatsapp_fallback_enabled' => data_get(config('services.whatsapp.providers'), '1.enabled', false) ? '1' : '0',
            'whatsapp_fallback_endpoint' => (string) data_get(config('services.whatsapp.providers'), '1.endpoint', ''),
            'whatsapp_fallback_token' => (string) data_get(config('services.whatsapp.providers'), '1.token', ''),
            'whatsapp_fallback_retries' => (string) data_get(config('services.whatsapp.providers'), '1.max_retries', 1),
        ];

        $rows = [];
        foreach ($definitions as $key => $definition) {
            $hasOverride = array_key_exists($key, $savedValues);
            $savedValue = $hasOverride ? (string) $savedValues[$key] : null;
            $defaultValue = (string) ($defaults[$key] ?? '');

            $rows[] = [
                'key' => $key,
                'label' => (string) $definition['label'],
                'description' => (string) ($definition['description'] ?? ''),
                'type' => (string) ($definition['type'] ?? 'text'),
                'has_override' => $hasOverride,
                'saved_value' => $savedValue,
                'effective_value' => $hasOverride ? (string) $savedValue : $defaultValue,
                'default_value' => $defaultValue,
            ];
        }

        return $rows;
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