<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Queue extends Model
{
    public const SERVICE_PREFIXES = [
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

    public const CLUSTER_SERVICE_MAP = [
        1 => [
            'Manajemen - Ruang TU',
            'Manajemen - Ruang Keuangan',
        ],
        2 => [
            'Ibu & Anak - Ruang KIA',
            'Ibu & Anak - Ruang VK/Bersalin',
            'Ibu & Anak - Ruangan Klaster 2 (Bayi/Balita/Remaja)',
            'Ibu & Anak - Ruang Imunisasi',
        ],
        3 => [
            'Usia Dewasa & Lansia - Ruangan Klaster 3 (Skrining PTM)',
        ],
        4 => [
            'Klaster 4 - Poli Anggrek (Penyakit Menular)',
            'Klaster 4 - Ruang TB',
            'Klaster 4 - Ruang Kesling',
            'Klaster 4 - Ruang Malaria',
        ],
        5 => [
            'Lintas Klaster - Ruang UGD & Observasi',
            'Lintas Klaster - Farmasi/Apotek',
            'Lintas Klaster - Laboratorium',
        ],
    ];

    protected $fillable = [
        'user_id',
        'queue_number',
        'patient_name',
        'nik',
        'complaint',
        'service_type',
        'queue_date',
        'status',
        'called_at',
        'called_by_role',
        'token',
        'token_scanned_at',
        'qr_path',
        'has_bpjs',
    ];

    protected $casts = [
        'queue_date' => 'date',
        'called_at' => 'datetime',
        'token_scanned_at' => 'datetime',
        'has_bpjs' => 'boolean',
    ];

    public static function servicesByCluster(int $clusterNumber): array
    {
        return self::CLUSTER_SERVICE_MAP[$clusterNumber] ?? [];
    }

    public function scopeArrivalOrder($query)
    {
        return $query
            ->orderByRaw('COALESCE(token_scanned_at, created_at) asc')
            ->orderBy('id');
    }

    public static function generateNextQueueNumber(string $serviceType, $date = null): string
    {
        $prefix = self::SERVICE_PREFIXES[$serviceType] ?? 'X';
        $queueDate = $date ? Carbon::parse($date)->toDateString() : now()->toDateString();

        $lastQueue = self::query()
            ->where('service_type', $serviceType)
            ->whereDate('queue_date', $queueDate)
            ->whereNotNull('queue_number')
            ->orderByDesc('queue_number')
            ->first();

        $lastNumber = 0;
        if ($lastQueue && preg_match('/(\d+)$/', (string) $lastQueue->queue_number, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        return $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    public function clusterNumber(): ?int
    {
        foreach (self::CLUSTER_SERVICE_MAP as $cluster => $services) {
            if (in_array($this->service_type, $services, true)) {
                return $cluster;
            }
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalExamination()
    {
        return $this->hasOne(MedicalExamination::class);
    }
}