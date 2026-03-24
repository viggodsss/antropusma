<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\PatientProfile;
use App\Models\MedicalExamination;
use App\Models\Prescription;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientController extends Controller
{
    private const FARMASI_SERVICE = 'Lintas Klaster - Farmasi/Apotek';

    /**
     * Tampilkan form pendaftaran
     */
    public function showForm(): View
    {
        return view('daftar');
    }

    /**
     * Simpan data pasien
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255|unique:pasiens,no_identitas',
        ]);

        Pasien::create($validated);

        return back()->with('success', 'Pendaftaran berhasil!');
    }

    /**
     * Dashboard pasien
     */
    public function dashboard()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        // Optional safety check (kalau route belum pakai middleware auth)
        if (!$user) {
            return redirect()->route('login');
        }

        $dailyResetCount = Queue::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'waiting', 'called'])
            ->whereDate('queue_date', '<', $today)
            ->update(['status' => 'cancelled']);

        $activeQueue = Queue::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'waiting', 'called'])
            ->whereDate('queue_date', $today)
            ->orderByRaw("CASE status WHEN 'called' THEN 1 WHEN 'waiting' THEN 2 WHEN 'approved' THEN 3 ELSE 4 END")
            ->latest('created_at')
            ->first();

        $serviceStatusMap = [
            'approved' => 'Menunggu Scan',
            'waiting' => 'Menunggu Panggilan',
            'called' => 'Dipanggil',
            'served' => 'Selesai',
            'pending' => 'Menunggu Persetujuan',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];

        $activeServiceLabel = $activeQueue
            ? ($serviceStatusMap[$activeQueue->status] ?? ucfirst((string) $activeQueue->status))
            : '-';

        $pharmacyQueue = Queue::where('user_id', $user->id)
            ->where('service_type', self::FARMASI_SERVICE)
            ->whereIn('status', ['approved', 'waiting', 'called'])
            ->whereDate('queue_date', $today)
            ->latest('created_at')
            ->first();

        $lastServedPharmacyQueue = Queue::where('user_id', $user->id)
            ->where('service_type', self::FARMASI_SERVICE)
            ->where('status', 'served')
            ->whereDate('queue_date', $today)
            ->latest('updated_at')
            ->first();

        $flowCompleted = !$activeQueue && (bool) $lastServedPharmacyQueue;

        return view('patient.dashboard', [
            'user' => $user,
            'activeQueue' => $activeQueue,
            'activeServiceLabel' => $activeServiceLabel,
            'pharmacyQueue' => $pharmacyQueue,
            'flowCompleted' => $flowCompleted,
            'dailyResetCount' => $dailyResetCount,
        ]);
    }

    /**
     * Tampilkan profil pasien
     */
    public function profile(): View
    {
        $user = Auth::user();
        $profile = $user->profile ?? new PatientProfile(['user_id' => $user->id]);

        return view('patient.profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update profil pasien
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        $validated = $request->validate([
            'nik' => 'nullable|string|size:16|unique:patient_profiles,nik,' . ($profile?->id ?? 'NULL'),
            'no_bpjs' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'golongan_darah' => 'nullable|string|max:3',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_telepon' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'nama_keluarga' => 'nullable|string|max:255',
            'hubungan_keluarga' => 'nullable|string|max:255',
            'no_telepon_keluarga' => 'nullable|string|max:20',
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'profile_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
            'ktp_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            'kk_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            'bpjs_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            'rme_card_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            'supporting_identity_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
        ]);

        $uploadTo = function (string $requestKey, string $dbKey, string $folder) use ($request, &$validated, $profile): void {
            if (!$request->hasFile($requestKey)) {
                return;
            }

            if ($profile && !empty($profile->{$dbKey})) {
                Storage::disk('public')->delete($profile->{$dbKey});
            }

            $validated[$dbKey] = $request->file($requestKey)->store($folder, 'public');
        };

        $uploadTo('profile_photo', 'profile_photo_path', 'patient-documents/profile-photo');
        $uploadTo('ktp_photo', 'ktp_photo_path', 'patient-documents/ktp');
        $uploadTo('kk_photo', 'kk_photo_path', 'patient-documents/kk');
        $uploadTo('bpjs_photo', 'bpjs_photo_path', 'patient-documents/bpjs');
        $uploadTo('rme_card_photo', 'rme_card_photo_path', 'patient-documents/rme-card');
        $uploadTo('supporting_identity_photo', 'supporting_identity_photo_path', 'patient-documents/supporting');

        unset(
            $validated['profile_photo'],
            $validated['ktp_photo'],
            $validated['kk_photo'],
            $validated['bpjs_photo'],
            $validated['rme_card_photo'],
            $validated['supporting_identity_photo']
        );

        if ($profile) {
            $profile->update($validated);
        } else {
            $validated['user_id'] = $user->id;
            PatientProfile::create($validated);
        }

        return redirect()->route('patient.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Daftar Berobat / Riwayat Pendaftaran Antrian
     */
    public function registrations(): View
    {
        $user = Auth::user();
        $registrations = Queue::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.registrations', [
            'user' => $user,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Riwayat Pemeriksaan (read-only)
     */
    public function examinations(): View
    {
        $user = Auth::user();
        $examinations = MedicalExamination::where('user_id', $user->id)
            ->with('queue')
            ->orderBy('tanggal_periksa', 'desc')
            ->paginate(10);

        return view('patient.examinations', [
            'user' => $user,
            'examinations' => $examinations,
        ]);
    }

    /**
     * Detail Pemeriksaan (read-only)
     */
    public function showExamination(MedicalExamination $examination): View
    {
        $user = Auth::user();

        // Pastikan pasien hanya bisa melihat pemeriksaan miliknya sendiri
        if ($examination->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('patient.examination-detail', [
            'user' => $user,
            'examination' => $examination->load('prescriptions'),
        ]);
    }

    /**
     * Resep Obat (read-only)
     */
    public function prescriptions(): View
    {
        $user = Auth::user();

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

        $prescriptions = Prescription::where('user_id', $user->id)
            ->with('medicalExamination')
            ->orderByRaw('COALESCE(tanggal_resep, DATE(created_at)) DESC')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('patient.prescriptions', [
            'user' => $user,
            'prescriptions' => $prescriptions,
        ]);
    }
}