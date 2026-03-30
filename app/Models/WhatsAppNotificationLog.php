<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppNotificationLog extends Model
{
    protected $table = 'whatsapp_notification_logs';

    protected $fillable = [
        'queue_id',
        'provider_name',
        'event',
        'phone_number',
        'attempt',
        'status',
        'http_status',
        'endpoint',
        'request_payload',
        'response_body',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'sent_at' => 'datetime',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
