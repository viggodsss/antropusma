<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien;

class QueueToken extends Model

{
    protected $dates = ['expires_at'];

    public function patient()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function isValid(): bool
    {
        return !$this->used && now()->lt($this->expires_at);
    }
}