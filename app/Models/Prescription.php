<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_examination_id',
        'nomor_resep',
        'tanggal_resep',
        'nama_dokter',
        'user_id',
        'nama_obat',
        'jumlah',
        'dosis',
        'aturan_pakai',
        'catatan',
        'status',
        'waktu_diambil',
    ];

    protected $casts = [
        'tanggal_resep' => 'date',
        'waktu_diambil' => 'datetime',
    ];

    public function medicalExamination()
    {
        return $this->belongsTo(MedicalExamination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'menunggu' => 'Menunggu',
            'disiapkan' => 'Sedang Disiapkan',
            'diambil' => 'Selesai',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'menunggu' => 'yellow',
            'disiapkan' => 'blue',
            'diambil' => 'green',
            default => 'gray',
        };
    }
}
