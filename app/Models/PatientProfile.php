<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'no_bpjs',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'no_telepon',
        'no_hp',
        'pekerjaan',
        'pendidikan',
        'status_pernikahan',
        'nama_keluarga',
        'hubungan_keluarga',
        'no_telepon_keluarga',
        'riwayat_alergi',
        'riwayat_penyakit',
        'profile_photo_path',
        'ktp_photo_path',
        'kk_photo_path',
        'bpjs_photo_path',
        'rme_card_photo_path',
        'supporting_identity_photo_path',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        return $this->tanggal_lahir->age;
    }

    public function getAlamatLengkapAttribute()
    {
        $parts = array_filter([
            $this->alamat,
            $this->rt ? 'RT ' . $this->rt : null,
            $this->rw ? 'RW ' . $this->rw : null,
            $this->kelurahan,
            $this->kecamatan,
            $this->kota,
            $this->provinsi,
            $this->kode_pos,
        ]);
        return implode(', ', $parts);
    }
}
