<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class QueueController extends Controller
{
    private const FARMASI_SERVICE = 'Lintas Klaster - Farmasi/Apotek';
    private const DISPLAY_VIDEO_KEY = 'display_local_videos';
    private const DISPLAY_VIDEO_ORDER_KEY = 'display_local_video_order';
    private const DISPLAY_VIDEO_SLOTS = 5;

    private const CLUSTER_GROUPS = [
        'Klaster 1 Manajemen' => [
            'Manajemen - Ruang TU',
            'Manajemen - Ruang Keuangan',
        ],
        'Klaster 2 Ibu dan Anak' => [
            'Ibu & Anak - Ruang KIA',
            'Ibu & Anak - Ruang VK/Bersalin',
            'Ibu & Anak - Ruangan Klaster 2 (Bayi/Balita/Remaja)',
            'Ibu & Anak - Ruang Imunisasi',
        ],
        'Klaster 3 Usia Dewasa dan Lansia' => [
            'Usia Dewasa & Lansia - Ruangan Klaster 3 (Skrining PTM)',
        ],
        'Klaster 4 Penyakit Menular & Kesling' => [
            'Klaster 4 - Poli Anggrek (Penyakit Menular)',
            'Klaster 4 - Ruang TB',
            'Klaster 4 - Ruang Kesling',
            'Klaster 4 - Ruang Malaria',
        ],
        'Klaster 5 Lintas Klaster' => [
            'Lintas Klaster - Ruang UGD & Observasi',
            'Lintas Klaster - Farmasi/Apotek',
            'Lintas Klaster - Laboratorium',
        ],
    ];

    // Tampilkan antrian untuk publik
    public function display()
    {
        $today = now()->toDateString();

        // Tampilkan hanya panggilan dari loket (admin) — panggilan petugas hanya notifikasi di tiket pasien
        $current = Queue::where('status', 'called')
            ->where('called_by_role', 'admin')
            ->whereDate('queue_date', $today)
            ->latest('called_at')
            ->first();

        if ($current) {
            $current->service_type = $this->sanitizeDisplayServiceType($current->service_type);
        }
        
        $waiting = Queue::where('status', 'waiting')
            ->whereDate('queue_date', $today)
            ->arrivalOrder()
            ->get();

        $localVideoUrls = $this->getDisplayLocalVideoUrls();

        return response()
            ->view('queue.display', compact('current', 'waiting', 'localVideoUrls'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function getDisplayPlaylistVideoIds(): array
    {
        $playlistJson = Setting::getValue('display_youtube_playlist', '[]');
        $playlist = json_decode($playlistJson, true) ?: [];

        $videoIds = [];
        foreach ($playlist as $url) {
            $videoId = $this->extractYoutubeVideoId($url);
            if ($videoId) {
                $videoIds[] = $videoId;
            }
        }

        return $videoIds;
    }

    private function getDisplayPlaylistEmbeds(): array
    {
        return array_map(function (string $videoId) {
            return $this->buildYoutubeEmbedUrl($videoId);
        }, $this->getDisplayPlaylistVideoIds());
    }

    private function buildYoutubeEmbedUrl(string $videoId): string
    {
        return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&loop=1&playlist={$videoId}";
    }

    private function extractYoutubeVideoId(?string $url): string
    {
        if (!$url) {
            return '';
        }

        // Format: youtube.com/watch?v=VIDEO_ID (with any query order)
        if (preg_match('/(?:youtube\.com\/watch\?.*?[&?]v=)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        // Format: youtu.be/VIDEO_ID
        if (preg_match('/(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        // Format: youtube.com/embed/VIDEO_ID
        if (preg_match('/(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        // Format: youtube.com/live/VIDEO_ID
        if (preg_match('/(?:youtube\.com\/live\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        // Format: youtube.com/shorts/VIDEO_ID
        if (preg_match('/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Convert YouTube URL to embed format
     */
    private function convertYoutubeToEmbed(?string $url): string
    {
        $videoId = $this->extractYoutubeVideoId($url);
        return $videoId ? $this->buildYoutubeEmbedUrl($videoId) : '';
    }

    // JSON endpoint untuk display (auto-refresh)
    public function displayData(): JsonResponse
    {
        $today = now()->toDateString();

        // Hanya panggilan loket (admin) yang ditampilkan di layar publik
        $current = Queue::where('status', 'called')
            ->where('called_by_role', 'admin')
            ->whereDate('queue_date', $today)
            ->latest('called_at')
            ->latest('id')
            ->first();
        
        $waiting = Queue::where('status', 'waiting')
            ->whereDate('queue_date', $today)
            ->arrivalOrder()
            ->get(['id', 'queue_number', 'patient_name', 'service_type']);

        $localVideoUrls = $this->getDisplayLocalVideoUrls();
        $localVideoSignature = md5(json_encode($localVideoUrls));

        return response()->json([
            'current' => $current ? [
                'id' => $current->id,
                'queue_number' => $current->queue_number,
                'patient_name' => $current->patient_name,
                'service_type' => $this->sanitizeDisplayServiceType($current->service_type),
                'called_at' => optional($current->called_at)->format('Y-m-d H:i:s'),
            ] : null,
            'waiting' => $waiting,
            'local_video_urls' => $localVideoUrls,
            'local_video_signature' => $localVideoSignature,
        ])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }

    private function sanitizeDisplayServiceType(?string $serviceType): string
    {
        $serviceType = trim((string) $serviceType);
        if ($serviceType === '') {
            return '-';
        }

        // Hard clean known noisy token that appeared in display payload.
        $serviceType = preg_replace('/\bghost\s*user\b/i', '', $serviceType) ?? $serviceType;
        $serviceType = trim(preg_replace('/\s+/', ' ', $serviceType) ?? $serviceType);

        // If valid service label, keep as-is.
        if (array_key_exists($serviceType, Queue::SERVICE_PREFIXES)) {
            return $serviceType;
        }

        // Fallback: return first matching known cluster family label.
        $lower = Str::lower($serviceType);
        if (Str::contains($lower, 'manajemen')) {
            return 'Manajemen';
        }
        if (Str::contains($lower, 'ibu') || Str::contains($lower, 'anak')) {
            return 'Ibu & Anak';
        }
        if (Str::contains($lower, 'dewasa') || Str::contains($lower, 'lansia')) {
            return 'Usia Dewasa & Lansia';
        }
        if (Str::contains($lower, 'klaster 4') || Str::contains($lower, 'tb') || Str::contains($lower, 'malaria')) {
            return 'Klaster 4';
        }
        if (Str::contains($lower, 'lintas') || Str::contains($lower, 'farmasi') || Str::contains($lower, 'ugd') || Str::contains($lower, 'laboratorium')) {
            return 'Lintas Klaster';
        }

        return $serviceType;
    }

    private function getDisplayLocalVideoUrls(): array
    {
        $json = Setting::getValue(self::DISPLAY_VIDEO_KEY, '[]');
        $paths = json_decode((string) $json, true);
        if (!is_array($paths)) {
            $paths = [];
        }

        $orderJson = Setting::getValue(self::DISPLAY_VIDEO_ORDER_KEY, '[]');
        $order = json_decode((string) $orderJson, true);
        if (!is_array($order)) {
            $order = [];
        }

        $normalizedOrder = [];
        foreach ($order as $slot) {
            $slotNumber = (int) $slot;
            if ($slotNumber >= 1 && $slotNumber <= self::DISPLAY_VIDEO_SLOTS && !in_array($slotNumber, $normalizedOrder, true)) {
                $normalizedOrder[] = $slotNumber;
            }
        }
        for ($slot = 1; $slot <= self::DISPLAY_VIDEO_SLOTS; $slot++) {
            if (!in_array($slot, $normalizedOrder, true)) {
                $normalizedOrder[] = $slot;
            }
        }

        $urls = [];
        foreach ($normalizedOrder as $slotNumber) {
            $index = $slotNumber - 1;
            $path = $paths[$index] ?? '';
            if (!is_string($path) || $path === '' || !Storage::disk('public')->exists($path)) {
                continue;
            }
            $urls[] = asset('storage/' . $path);
        }

        return $urls;
    }

    // Form pendaftaran antrian untuk pasien
    public function register(Request $request)
    {
        $klasters = array_keys(Queue::SERVICE_PREFIXES);
        $clusterGroups = self::CLUSTER_GROUPS;
        $selectedService = $request->query('service_type');

        if (!in_array($selectedService, $klasters, true)) {
            $selectedService = null;
        }

        return view('queue.register', compact('klasters', 'clusterGroups', 'selectedService'));
    }

    // Simpan antrian baru
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'complaint' => 'nullable|string',
            'service_type' => 'required|string|in:' . implode(',', array_keys(Queue::SERVICE_PREFIXES)),
            'has_bpjs' => 'nullable|boolean',
        ]);

        // Generate token unik untuk sekali pakai
        $token = Str::uuid()->toString();

        $queue = Queue::create([
            'user_id' => auth()->id(),
            'queue_number' => null,
            'patient_name' => $request->patient_name,
            'nik' => $request->nik,
            'complaint' => $request->complaint,
            'service_type' => $request->service_type,
            'queue_date' => now()->toDateString(),
            'status' => 'approved',
            'token' => $token,
            'has_bpjs' => (bool) $request->has_bpjs,
        ]);

        // Generate QR Code dengan error handling
        try {
            $qrDir = storage_path('app/public/qr_codes');
            if (!is_dir($qrDir)) {
                mkdir($qrDir, 0755, true);
            }

            $qrFileName = 'qr_' . $queue->id . '.png';
            $qrFullPath = $qrDir . '/' . $qrFileName;
            $qrRelativePath = 'qr_codes/' . $qrFileName;

            $ticketUrl = route('admin.queue.scan', ['queue' => $queue, 'token' => $token]);

            $result = \Endroid\QrCode\Builder\Builder::create()
                ->writer(new \Endroid\QrCode\Writer\PngWriter())
                ->data($ticketUrl)
                ->size(200)
                ->margin(10)
                ->build();

            $result->saveToFile($qrFullPath);
            $queue->update(['qr_path' => $qrRelativePath]);
        } catch (\Exception $e) {
            // Jika QR gagal generate, tetap lanjutkan (token masih berlaku)
            Log::error('QR Code generation failed: ' . $e->getMessage());
        }

        return redirect()->route('queue.show', ['queue' => $queue]);
    }

    // Lihat tiket (nomor + barcode)
    public function show(Queue $queue)
    {
        // Validasi queue exists
        if (!$queue) {
            abort(404, 'Antrian tidak ditemukan.');
        }

        $nextPharmacyQueue = null;
        $needsPharmacyStep = false;
        $isFinalAtPharmacy = false;
        $isExpiredTicket = false;

        if (in_array($queue->status, ['approved', 'waiting', 'called'], true)
            && $queue->queue_date
            && $queue->queue_date->toDateString() < now()->toDateString()) {
            $queue->update(['status' => 'cancelled']);
            $queue->refresh();
            $isExpiredTicket = true;
        }

        if ($queue->status === 'served') {
            $isFinalAtPharmacy = $queue->service_type === self::FARMASI_SERVICE;

            if (!$isFinalAtPharmacy && $queue->user_id) {
                $nextPharmacyQueue = Queue::where('user_id', $queue->user_id)
                    ->where('service_type', self::FARMASI_SERVICE)
                    ->whereIn('status', ['approved', 'waiting', 'called'])
                    ->latest('created_at')
                    ->first();

                $needsPharmacyStep = (bool) $nextPharmacyQueue;
            }
        }

        return view('queue.ticket', compact('queue', 'nextPharmacyQueue', 'needsPharmacyStep', 'isFinalAtPharmacy', 'isExpiredTicket'));
    }

}

