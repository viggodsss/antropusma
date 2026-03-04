<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'queue_number',
        'patient_name',
        'nik',
        'complaint',
        'service_type',
        'status',
        'called_at',
        'token',
        'token_scanned_at',
        'qr_path',
    ];
}