<?php

use App\Models\Queue;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\PatientRegistrationOtpNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

it('registers patient with phone, sends OTP email, verifies OTP, and auto logs in', function () {
    Notification::fake();

    $response = $this->post(route('register'), [
        'name' => 'Pasien Uji',
        'email' => 'pasien.otp@example.test',
        'phone' => '0812-3456-7890',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('otp.verify.form'));

    $user = User::where('email', 'pasien.otp@example.test')->first();
    expect($user)->not->toBeNull();
    expect($user->status)->toBe('pending');
    expect($user->phone)->toBe('6281234567890');

    $otpCode = null;
    Notification::assertSentTo(
        [$user],
        PatientRegistrationOtpNotification::class,
        function (PatientRegistrationOtpNotification $notification) use (&$otpCode) {
            $reflection = new ReflectionClass($notification);
            $property = $reflection->getProperty('otp');
            $property->setAccessible(true);
            $otpCode = (string) $property->getValue($notification);

            return strlen($otpCode) === 6;
        }
    );

    expect($otpCode)->not->toBeNull();
    expect(Hash::check($otpCode, (string) $user->otp_code_hash))->toBeTrue();

    $verifyResponse = $this->post(route('otp.verify.submit'), [
        'otp' => $otpCode,
    ]);

    $verifyResponse->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);

    $user->refresh();
    expect($user->status)->toBe('approved');
    expect($user->verified_at)->not->toBeNull();
    expect($user->email_verified_at)->not->toBeNull();
    expect($user->otp_code_hash)->toBeNull();
    expect($user->otp_expires_at)->toBeNull();
    expect($user->otp_attempts)->toBe(0);
});

it('sends WhatsApp HTTP request when admin calls next queue', function () {
    Http::fake([
        'https://wa.test/send' => Http::response(['ok' => true], 200),
    ]);

    Setting::setValue('wa_enabled', '1');
    Setting::setValue('wa_endpoint', 'https://wa.test/send');
    Setting::setValue('wa_token', 'secret-token');
    Setting::setValue('wa_sender', 'Puskesmas');
    Setting::setValue('wa_template', 'Halo {name}, nomor {queue_number} dipanggil ke {service_type}.');

    $patient = User::factory()->create([
        'name' => 'Pasien WA',
        'email' => 'pasien.wa@example.test',
        'role' => 'patient',
        'status' => 'approved',
        'phone' => '08123456789',
    ]);

    $admin = User::factory()->create([
        'name' => 'Admin Loket',
        'email' => 'admin.wa@example.test',
        'role' => 'admin',
        'status' => 'approved',
    ]);

    Queue::create([
        'user_id' => $patient->id,
        'queue_number' => 'M001',
        'patient_name' => $patient->name,
        'nik' => '1234567890123456',
        'service_type' => 'Manajemen - Ruang TU',
        'queue_date' => now()->toDateString(),
        'status' => 'waiting',
        'has_bpjs' => false,
    ]);

    $response = $this->actingAs($admin)->post(route('admin.callNext'));

    $response->assertStatus(302);

    Http::assertSent(function ($request) {
        $data = $request->data();

        return $request->url() === 'https://wa.test/send'
            && $request->hasHeader('Authorization', 'Bearer secret-token')
            && ($data['to'] ?? null) === '628123456789'
            && ($data['queue_number'] ?? null) === 'M001'
            && str_contains((string) ($data['message'] ?? ''), 'M001');
    });

    $calledQueue = Queue::first();
    expect($calledQueue->status)->toBe('called');
    expect($calledQueue->called_by_role)->toBe('admin');
});
