<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalExamination extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'queue_id',
        'tanggal_periksa',
        'dokter_pemeriksa',
        'poli_tujuan',
        'keluhan_utama',
        'riwayat_penyakit_sekarang',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'nadi',
        'suhu',
        'respirasi',
        'berat_badan',
        'tinggi_badan',
        'hasil_pemeriksaan_fisik',
        'diagnosa',
        'kode_icd10',
        'tindakan',
        'anjuran',
        'status',
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
        'suhu' => 'decimal:1',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function getTekananDarahAttribute()
    {
        if ($this->tekanan_darah_sistolik && $this->tekanan_darah_diastolik) {
            return $this->tekanan_darah_sistolik . '/' . $this->tekanan_darah_diastolik . ' mmHg';
        }
        return null;
    }

    public function getImtAttribute()
    {
        if ($this->berat_badan && $this->tinggi_badan) {
            $tinggiMeter = $this->tinggi_badan / 100;
            return round($this->berat_badan / ($tinggiMeter * $tinggiMeter), 1);
        }
        return null;
    }
}
