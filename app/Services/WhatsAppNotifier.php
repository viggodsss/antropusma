<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotifier
{
    public function sendQueueCalledNotification(Queue $queue): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $endpoint = trim((string) Setting::getValue('wa_endpoint', ''));
        if ($endpoint === '') {
            return;
        }

        $queue->loadMissing('user.profile');

        $phone = $this->resolvePhone($queue);
        if ($phone === null) {
            return;
        }

        $token = trim((string) Setting::getValue('wa_token', ''));
        $sender = trim((string) Setting::getValue('wa_sender', 'Puskesmas'));
        $template = (string) Setting::getValue(
            'wa_template',
            'Halo {name}, nomor antrian {queue_number} sedang dipanggil ke {service_type}. Silakan segera menuju lokasi layanan.'
        );

        $message = strtr($template, [
            '{name}' => (string) $queue->patient_name,
            '{queue_number}' => (string) ($queue->queue_number ?: '-'),
            '{service_type}' => (string) $queue->service_type,
            '{called_by_role}' => (string) ($queue->called_by_role ?: '-'),
        ]);

        $payload = [
            'to' => $phone,
            'phone' => $phone,
            'recipient' => $phone,
            'sender' => $sender,
            'message' => $message,
            'text' => $message,
            'queue_number' => (string) ($queue->queue_number ?: ''),
            'patient_name' => (string) $queue->patient_name,
            'service_type' => (string) $queue->service_type,
            'called_by_role' => (string) ($queue->called_by_role ?: ''),
        ];

        try {
            $request = Http::acceptJson()->timeout(10);

            if ($token !== '') {
                $request = $request->withToken($token);
            }

            $response = $request->post($endpoint, $payload);

            if ($response->failed()) {
                Log::warning('WA notification failed', [
                    'queue_id' => $queue->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('WA notification error', [
                'queue_id' => $queue->id,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function isEnabled(): bool
    {
        return filter_var(Setting::getValue('wa_enabled', false), FILTER_VALIDATE_BOOLEAN);
    }

    private function resolvePhone(Queue $queue): ?string
    {
        $raw = (string) (
            $queue->user?->phone
            ?? $queue->user?->profile?->no_hp
            ?? $queue->user?->profile?->no_telepon
            ?? ''
        );

        $normalized = $this->normalizePhone($raw);

        return $normalized !== '' ? $normalized : null;
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }
}
