<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
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
        'no_hp',
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

    public function whatsappNotificationLogs()
    {
        return $this->hasMany(WhatsAppNotificationLog::class);
    }
}