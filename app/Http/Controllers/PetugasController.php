<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppQueueNotifier;
use App\Models\MedicalExamination;
use App\Models\Prescription;
use App\Models\Queue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function __construct(private readonly WhatsAppQueueNotifier $whatsAppQueueNotifier)
    {
    }

    private const EXAMINATION_CLUSTERS = [2, 3, 4];

    public function dashboard(): View
    {
        $user = Auth::user();
        $cluster = (int) ($user->cluster_number ?? 0);
        $services = Queue::servicesByCluster($cluster);

        $queueBase = Queue::query()->whereIn('service_type', $services);

        $counts = [
            'total' => (clone $queueBase)->count(),
            'belum_scan' => (clone $queueBase)->where('status', 'approved')->count(),
            'menunggu' => (clone $queueBase)->where('status', 'waiting')->count(),
            'selesai' => (clone $queueBase)->where('status', 'served')->count(),
        ];

        $waitingQueues = (clone $queueBase)
            ->where('status', 'waiting')
            ->orderByRaw('COALESCE(token_scanned_at, created_at) asc')
            ->orderBy('id')
            ->limit(15)
            ->get();

        $calledQueues = (clone $queueBase)
            ->where('status', 'called')
            ->orderByDesc('called_at')
            ->limit(10)
            ->get();

        $complaints = (clone $queueBase)
            ->whereNotNull('complaint')
            ->where('complaint', '!=', '')
            ->latest('created_at')
            ->limit(10)
            ->get();

        $prescriptionInbox = collect();
        $recentExaminations = collect();

        if (in_array($cluster, self::EXAMINATION_CLUSTERS, true)) {
            $recentExaminations = MedicalExamination::with('user')
                ->whereIn('poli_tujuan', $services)
                ->latest('created_at')
                ->limit(10)
                ->get();
        }

        if ($cluster === 5) {
            $prescriptionInbox = Prescription::with(['user', 'medicalExamination'])
                ->whereIn('status', ['menunggu', 'disiapkan'])
                ->latest('created_at')
                ->limit(20)
                ->get();
        }

        return view('petugas.dashboard', [
            'user' => $user,
            'cluster' => $cluster,
            'services' => $services,
            'counts' => $counts,
            'waitingQueues' => $waitingQueues,
            'calledQueues' => $calledQueues,
            'complaints' => $complaints,
            'prescriptionInbox' => $prescriptionInbox,
            'recentExaminations' => $recentExaminations,
        ]);
    }

    public function callNext(): RedirectResponse
    {
        $user = Auth::user();
        $services = Queue::servicesByCluster((int) ($user->cluster_number ?? 0));

        $queue = Queue::whereIn('service_type', $services)
            ->where('status', 'waiting')
            ->orderByRaw('COALESCE(token_scanned_at, created_at) asc')
            ->orderBy('id')
            ->first();

        if (!$queue) {
            return redirect()->route('petugas.dashboard')->with('info', 'Tidak ada antrian menunggu untuk klaster Anda.');
        }

        $queue->update([
            'status' => 'called',
            'called_at' => now(),
            'called_by_role' => 'petugas',
        ]);

        $this->whatsAppQueueNotifier->sendQueueEvent($queue->fresh(), 'called');

        return redirect()->route('petugas.dashboard')->with('success', "Antrian {$queue->queue_number} dipanggil untuk pasien.");
    }

    // Fallback when call-next is opened directly from URL (GET)
    public function callNextFromUrl(): RedirectResponse
    {
        return $this->callNext();
    }

    public function markServed(Queue $queue): RedirectResponse
    {
        $user = Auth::user();
        $services = Queue::servicesByCluster((int) ($user->cluster_number ?? 0));

        if (!in_array($queue->service_type, $services, true)) {
            return redirect()->route('petugas.dashboard')->with('error', 'Antrian tidak termasuk klaster Anda.');
        }

        $queue->update(['status' => 'served']);

        $this->whatsAppQueueNotifier->sendQueueEvent($queue->fresh(), 'served');

        $isFarmasiQueue = $queue->service_type === 'Lintas Klaster - Farmasi/Apotek';
        if ((int) ($user->cluster_number ?? 0) === 5 && $isFarmasiQueue) {
            Prescription::where('user_id', $queue->user_id)
                ->whereIn('status', ['menunggu', 'disiapkan'])
                ->update([
                    'status' => 'diambil',
                    'waktu_diambil' => now(),
                ]);
        }

        return redirect()->route('petugas.dashboard')->with('success', "Antrian {$queue->queue_number} ditandai selesai.");
    }

    public function createExamination(Queue $queue): View|RedirectResponse
    {
        $user = Auth::user();
        $cluster = (int) ($user->cluster_number ?? 0);

        if (!in_array($cluster, self::EXAMINATION_CLUSTERS, true)) {
            return redirect()->route('petugas.dashboard')->with('error', 'Fitur pemeriksaan hanya untuk petugas klaster 2, 3, dan 4.');
        }

        $services = Queue::servicesByCluster($cluster);
        if (!in_array($queue->service_type, $services, true)) {
            return redirect()->route('petugas.dashboard')->with('error', 'Antrian tidak termasuk klaster Anda.');
        }

        if ($queue->status !== 'called' && $queue->status !== 'waiting') {
            return redirect()->route('petugas.dashboard')->with('error', 'Antrian pasien tidak dalam proses layanan.');
        }

        return view('petugas.examination-form', [
            'queue' => $queue,
            'user' => $user,
        ]);
    }

    public function storeExamination(Request $request, Queue $queue): RedirectResponse
    {
        $user = Auth::user();
        $cluster = (int) ($user->cluster_number ?? 0);

        if (!in_array($cluster, self::EXAMINATION_CLUSTERS, true)) {
            return redirect()->route('petugas.dashboard')->with('error', 'Fitur pemeriksaan hanya untuk petugas klaster 2, 3, dan 4.');
        }

        $services = Queue::servicesByCluster($cluster);
        if (!in_array($queue->service_type, $services, true)) {
            return redirect()->route('petugas.dashboard')->with('error', 'Antrian tidak termasuk klaster Anda.');
        }

        $validated = $request->validate([
            'tanggal_periksa' => 'required|date',
            'dokter_pemeriksa' => 'required|string|max:255',
            'tekanan_darah_sistolik' => 'nullable|numeric',
            'tekanan_darah_diastolik' => 'nullable|numeric',
            'nadi' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'respirasi' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'keluhan_utama' => 'nullable|string',
            'hasil_pemeriksaan_fisik' => 'nullable|string',
            'diagnosa' => 'required|string',
            'kode_icd10' => 'nullable|string|max:20',
            'tindakan' => 'nullable|string',
            'anjuran' => 'nullable|string',
            'nama_obat' => 'nullable|array',
            'nama_obat.*' => 'nullable|string|max:255',
            'jumlah' => 'nullable|array',
            'jumlah.*' => 'nullable|string|max:255',
            'dosis' => 'nullable|array',
            'dosis.*' => 'nullable|string|max:255',
            'aturan_pakai' => 'nullable|array',
            'aturan_pakai.*' => 'nullable|string|max:255',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string',
        ]);

        $exam = MedicalExamination::create([
            'user_id' => $queue->user_id,
            'queue_id' => $queue->id,
            'tanggal_periksa' => $validated['tanggal_periksa'],
            'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
            'poli_tujuan' => $queue->service_type,
            'keluhan_utama' => $validated['keluhan_utama'] ?? $queue->complaint,
            'hasil_pemeriksaan_fisik' => $validated['hasil_pemeriksaan_fisik'] ?? null,
            'tekanan_darah_sistolik' => $validated['tekanan_darah_sistolik'] ?? null,
            'tekanan_darah_diastolik' => $validated['tekanan_darah_diastolik'] ?? null,
            'nadi' => $validated['nadi'] ?? null,
            'suhu' => $validated['suhu'] ?? null,
            'respirasi' => $validated['respirasi'] ?? null,
            'berat_badan' => $validated['berat_badan'] ?? null,
            'tinggi_badan' => $validated['tinggi_badan'] ?? null,
            'diagnosa' => $validated['diagnosa'],
            'kode_icd10' => $validated['kode_icd10'] ?? null,
            'tindakan' => $validated['tindakan'] ?? null,
            'anjuran' => $validated['anjuran'] ?? null,
            'status' => 'selesai',
        ]);

        $hasPrescription = false;
        $obatList = $validated['nama_obat'] ?? [];
        $prescriptionCount = Prescription::whereDate('created_at', now()->toDateString())->count() + 1;

        foreach ($obatList as $index => $namaObat) {
            if (!$namaObat) {
                continue;
            }

            $hasPrescription = true;
            $nomorResep = 'RX-' . now()->format('Ymd') . '-' . str_pad($prescriptionCount + $index, 3, '0', STR_PAD_LEFT);
            
            Prescription::create([
                'medical_examination_id' => $exam->id,
                'nomor_resep' => $nomorResep,
                'tanggal_resep' => now()->toDateString(),
                'nama_dokter' => $validated['dokter_pemeriksa'],
                'user_id' => $queue->user_id,
                'nama_obat' => $namaObat,
                'jumlah' => $validated['jumlah'][$index] ?? null,
                'dosis' => $validated['dosis'][$index] ?? null,
                'aturan_pakai' => $validated['aturan_pakai'][$index] ?? null,
                'catatan' => $validated['catatan'][$index] ?? null,
                'status' => 'menunggu',
            ]);
        }

        $queue->update(['status' => 'served']);

        $message = 'Pemeriksaan berhasil disimpan.';
        if ($hasPrescription) {
            $farmasiService = 'Lintas Klaster - Farmasi/Apotek';

            $existingFarmasiQueue = Queue::where('user_id', $queue->user_id)
                ->where('service_type', $farmasiService)
                ->whereDate('queue_date', now()->toDateString())
                ->whereIn('status', ['approved', 'waiting', 'called'])
                ->first();

            if (!$existingFarmasiQueue) {
                $lastQueue = Queue::where('service_type', $farmasiService)
                    ->whereNotNull('queue_number')
                    ->orderBy('queue_number', 'desc')
                    ->first();

                $lastNumber = 0;
                if ($lastQueue && preg_match('/(\d+)$/', $lastQueue->queue_number, $matches)) {
                    $lastNumber = (int) $matches[1];
                }

                $farmasiNumber = 'L' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

                Queue::create([
                    'user_id' => $queue->user_id,
                    'queue_number' => $farmasiNumber,
                    'patient_name' => $queue->patient_name,
                    'nik' => $queue->nik,
                    'complaint' => 'Rujukan resep dari pemeriksaan ' . $queue->queue_number,
                    'service_type' => $farmasiService,
                    'queue_date' => now()->toDateString(),
                    'status' => 'waiting',
                ]);
            }

            $message .= ' Resep terkirim ke inbox petugas Klaster 5 (Farmasi/Apotek). Pasien dilanjutkan ke alur farmasi.';
        }

        return redirect()->route('petugas.dashboard')->with('success', $message);
    }

    public function updatePrescriptionStatus(Request $request, Prescription $prescription): RedirectResponse
    {
        $user = Auth::user();
        if ((int) ($user->cluster_number ?? 0) !== 5) {
            return redirect()->route('petugas.dashboard')->with('error', 'Fitur ini hanya untuk petugas klaster 5.');
        }

        $validated = $request->validate([
            'status' => 'required|in:disiapkan,diambil',
        ]);

        $payload = ['status' => $validated['status']];
        if ($validated['status'] === 'diambil') {
            $payload['waktu_diambil'] = now();
        }

        $prescription->update($payload);

        return redirect()->route('petugas.dashboard')->with('success', 'Status resep berhasil diperbarui.');
    }
}
