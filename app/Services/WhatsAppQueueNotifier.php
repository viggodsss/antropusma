<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\Setting;
use App\Models\WhatsAppNotificationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppQueueNotifier
{
    private ?array $settingsCache = null;

    public function sendQueueEvent(Queue $queue, string $event): bool
    {
        $enabled = $this->getSettingBool('whatsapp_api_enabled', (bool) config('services.whatsapp.enabled', false));
        if (!$enabled) {
            $this->writeLog($queue, [
                'provider_name' => 'system',
                'event' => $event,
                'phone_number' => null,
                'attempt' => 1,
                'status' => 'skipped',
                'http_status' => null,
                'endpoint' => null,
                'request_payload' => null,
                'response_body' => null,
                'error_message' => 'WhatsApp API disabled in config.',
                'sent_at' => null,
            ]);
            return false;
        }

        $queue->loadMissing('user.profile');

        // Prioritas: no_hp di tabel queues → profil pasien → no_telepon profil
        $phoneRaw = (string) (
            $queue->no_hp
            ?: optional($queue->user?->profile)->no_hp
            ?: optional($queue->user?->profile)->no_telepon
            ?: ''
        );

        $phone = $this->normalizePhoneNumber($phoneRaw);
        if ($phone === '') {
            Log::warning('WhatsApp not sent: nomor HP pasien kosong/tidak valid.', [
                'queue_id' => $queue->id,
                'event' => $event,
            ]);

            $this->writeLog($queue, [
                'provider_name' => 'system',
                'event' => $event,
                'phone_number' => $phoneRaw !== '' ? $phoneRaw : null,
                'attempt' => 1,
                'status' => 'skipped',
                'http_status' => null,
                'endpoint' => null,
                'request_payload' => null,
                'response_body' => null,
                'error_message' => 'Nomor HP tidak valid atau kosong.',
                'sent_at' => null,
            ]);
            return false;
        }

        $message = $this->buildMessage($queue, $event);
        $providers = $this->resolveProviders();

        if ($providers === []) {
            $this->writeLog($queue, [
                'provider_name' => 'system',
                'event' => $event,
                'phone_number' => $phone,
                'attempt' => 1,
                'status' => 'failed',
                'http_status' => null,
                'endpoint' => null,
                'request_payload' => null,
                'response_body' => null,
                'error_message' => 'Tidak ada provider WhatsApp yang aktif.',
                'sent_at' => null,
            ]);
            return false;
        }

        foreach ($providers as $provider) {
            $maxRetries = max(0, (int) ($provider['max_retries'] ?? 0));
            $attemptLimit = $maxRetries + 1;

            for ($attempt = 1; $attempt <= $attemptLimit; $attempt++) {
                $result = $this->sendWithProvider($provider, $phone, $message, $queue, $event);

                $this->writeLog($queue, [
                    'provider_name' => (string) ($provider['name'] ?? 'provider'),
                    'event' => $event,
                    'phone_number' => $phone,
                    'attempt' => $attempt,
                    'status' => $result['ok'] ? 'sent' : 'failed',
                    'http_status' => $result['http_status'],
                    'endpoint' => (string) ($provider['endpoint'] ?? null),
                    'request_payload' => $result['payload'],
                    'response_body' => $result['response_body'],
                    'error_message' => $result['error'],
                    'sent_at' => $result['ok'] ? now() : null,
                ]);

                if ($result['ok']) {
                    return true;
                }
            }
        }

        return false;
    }

    private function sendWithProvider(array $provider, string $phone, string $message, Queue $queue, string $event): array
    {
        $type = strtolower((string) ($provider['type'] ?? 'generic'));
        $token = (string) ($provider['token'] ?? '');
        $endpoint = (string) ($provider['endpoint'] ?? '');
        $timeout = max(3, $this->getSettingInt('whatsapp_api_timeout', (int) config('services.whatsapp.timeout', 10)));

        if ($endpoint === '') {
            return [
                'ok' => false,
                'http_status' => null,
                'response_body' => null,
                'error' => 'Endpoint kosong.',
                'payload' => null,
            ];
        }

        $payload = $this->buildProviderPayload($type, $phone, $message, $queue, $event);

        try {
            $request = Http::timeout($timeout)->acceptJson();

            if ($token !== '') {
                if ($type === 'fonnte') {
                    $request = $request->withHeaders(['Authorization' => $token]);
                } else {
                    $request = $request->withToken($token);
                }
            }

            $response = $request->post($endpoint, $payload);

            if ($response->failed()) {
                return [
                    'ok' => false,
                    'http_status' => $response->status(),
                    'response_body' => $response->body(),
                    'error' => 'HTTP request failed.',
                    'payload' => $payload,
                ];
            }

            return [
                'ok' => true,
                'http_status' => $response->status(),
                'response_body' => $response->body(),
                'error' => null,
                'payload' => $payload,
            ];
        } catch (\Throwable $e) {
            Log::warning('WhatsApp API request exception.', [
                'queue_id' => $queue->id,
                'event' => $event,
                'provider' => $provider['name'] ?? 'provider',
                'error' => $e->getMessage(),
            ]);

            return [
                'ok' => false,
                'http_status' => null,
                'response_body' => null,
                'error' => $e->getMessage(),
                'payload' => $payload,
            ];
        }
    }

    private function buildProviderPayload(string $type, string $phone, string $message, Queue $queue, string $event): array
    {
        if ($type === 'fonnte') {
            return [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62',
            ];
        }

        return [
            'phone' => $phone,
            'message' => $message,
            'queue_id' => $queue->id,
            'queue_number' => (string) ($queue->queue_number ?? '-'),
            'event' => $event,
        ];
    }

    private function resolveProviders(): array
    {
        $primaryFromSettings = [
            'name' => 'primary',
            'type' => $this->getSettingString('whatsapp_primary_type', (string) data_get(config('services.whatsapp.providers'), '0.type', 'fonnte')),
            'enabled' => $this->getSettingBool('whatsapp_primary_enabled', (bool) data_get(config('services.whatsapp.providers'), '0.enabled', true)),
            'endpoint' => $this->getSettingString('whatsapp_primary_endpoint', (string) data_get(config('services.whatsapp.providers'), '0.endpoint', '')),
            'token' => $this->getSettingString('whatsapp_primary_token', (string) data_get(config('services.whatsapp.providers'), '0.token', '')),
            'max_retries' => $this->getSettingInt('whatsapp_primary_retries', (int) data_get(config('services.whatsapp.providers'), '0.max_retries', 2)),
        ];

        $fallbackFromSettings = [
            'name' => 'fallback',
            'type' => $this->getSettingString('whatsapp_fallback_type', (string) data_get(config('services.whatsapp.providers'), '1.type', 'generic')),
            'enabled' => $this->getSettingBool('whatsapp_fallback_enabled', (bool) data_get(config('services.whatsapp.providers'), '1.enabled', false)),
            'endpoint' => $this->getSettingString('whatsapp_fallback_endpoint', (string) data_get(config('services.whatsapp.providers'), '1.endpoint', '')),
            'token' => $this->getSettingString('whatsapp_fallback_token', (string) data_get(config('services.whatsapp.providers'), '1.token', '')),
            'max_retries' => $this->getSettingInt('whatsapp_fallback_retries', (int) data_get(config('services.whatsapp.providers'), '1.max_retries', 1)),
        ];

        $providersFromSettings = array_values(array_filter([$primaryFromSettings, $fallbackFromSettings], function ($provider) {
            return is_array($provider)
                && (bool) ($provider['enabled'] ?? false)
                && is_string($provider['endpoint'] ?? null)
                && ($provider['endpoint'] ?? '') !== '';
        }));

        if ($providersFromSettings !== []) {
            return $providersFromSettings;
        }

        $providers = config('services.whatsapp.providers', []);
        if (is_array($providers) && $providers !== []) {
            return array_values(array_filter($providers, function ($provider) {
                return is_array($provider)
                    && (bool) ($provider['enabled'] ?? false)
                    && is_string($provider['endpoint'] ?? null)
                    && ($provider['endpoint'] ?? '') !== '';
            }));
        }

        $legacyEndpoint = (string) config('services.whatsapp.endpoint', '');
        if ($legacyEndpoint === '') {
            return [];
        }

        return [[
            'name' => 'legacy-primary',
            'type' => 'generic',
            'enabled' => true,
            'endpoint' => $legacyEndpoint,
            'token' => (string) config('services.whatsapp.token', ''),
            'max_retries' => 0,
        ]];
    }

    private function getSettingValue(string $key, $default = null)
    {
        $settings = $this->getSettingsCache();
        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }

    private function getSettingString(string $key, string $default = ''): string
    {
        $value = $this->getSettingValue($key, $default);
        return is_string($value) ? $value : (string) $value;
    }

    private function getSettingInt(string $key, int $default = 0): int
    {
        $value = $this->getSettingValue($key, $default);
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '' && is_numeric($value)) {
            return (int) $value;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return $default;
    }

    private function getSettingBool(string $key, bool $default = false): bool
    {
        $value = $this->getSettingValue($key, null);
        if ($value === null) {
            return $default;
        }

        if (is_bool($value)) {
            return $value;
        }

        $normalized = strtolower(trim((string) $value));
        if (in_array($normalized, ['1', 'true', 'yes', 'on'], true)) {
            return true;
        }

        if (in_array($normalized, ['0', 'false', 'no', 'off'], true)) {
            return false;
        }

        return $default;
    }

    private function getSettingsCache(): array
    {
        if ($this->settingsCache === null) {
            $this->settingsCache = Setting::query()->pluck('value', 'key')->all();
        }

        return $this->settingsCache;
    }

    private function writeLog(Queue $queue, array $data): void
    {
        WhatsAppNotificationLog::query()->create([
            'queue_id' => $queue->id,
            'provider_name' => (string) ($data['provider_name'] ?? 'provider'),
            'event' => (string) ($data['event'] ?? 'unknown'),
            'phone_number' => $data['phone_number'] ?? null,
            'attempt' => (int) ($data['attempt'] ?? 1),
            'status' => (string) ($data['status'] ?? 'failed'),
            'http_status' => $data['http_status'] ?? null,
            'endpoint' => $data['endpoint'] ?? null,
            'request_payload' => $data['request_payload'] ?? null,
            'response_body' => $data['response_body'] ?? null,
            'error_message' => $data['error_message'] ?? null,
            'sent_at' => $data['sent_at'] ?? null,
        ]);
    }

    private function buildMessage(Queue $queue, string $event): string
    {
        $queueNumber = (string) ($queue->queue_number ?? '-');
        $service = (string) ($queue->service_type ?? '-');
        $patient = (string) ($queue->patient_name ?? 'Pasien');

        return match ($event) {
            'waiting' => "[Puskesmas Mapurujaya]\nHalo {$patient}, QR Anda sudah berhasil dipindai. Nomor antrian Anda: {$queueNumber} ({$service}). Silakan menunggu panggilan.",
            'called' => "[Puskesmas Mapurujaya]\nHalo {$patient}, nomor antrian {$queueNumber} sedang dipanggil ke {$service}. Silakan segera menuju loket/ruangan terkait.",
            'served' => "[Puskesmas Mapurujaya]\nHalo {$patient}, layanan untuk nomor antrian {$queueNumber} sudah selesai. Terima kasih.",
            default => "[Puskesmas Mapurujaya]\nUpdate status antrian Anda ({$queueNumber}): {$event}.",
        };
    }

    private function normalizePhoneNumber(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        if (!str_starts_with($digits, '62')) {
            return '';
        }

        if (strlen($digits) < 10 || strlen($digits) > 16) {
            return '';
        }

        return $digits;
    }
}
