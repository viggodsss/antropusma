<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\PatientResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sends_a_password_reset_email_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'pasien.reset@example.com',
            'role' => 'patient',
            'status' => 'approved',
        ]);

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])->assertSessionHas('status');

        Notification::assertSentTo($user, PatientResetPasswordNotification::class);
    }

    public function test_it_allows_a_user_to_reset_the_password_from_the_email_link(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'petugas.reset@example.com',
            'password' => bcrypt('PasswordLama123!'),
            'role' => 'petugas',
            'status' => 'approved',
        ]);

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])->assertSessionHas('status');

        $resetUrl = null;

        Notification::assertSentTo($user, PatientResetPasswordNotification::class, function (PatientResetPasswordNotification $notification) use ($user, &$resetUrl) {
            $resetUrl = $notification->toMail($user)->actionUrl;

            return $resetUrl !== null;
        });

        $this->assertNotNull($resetUrl);
        /** @var string $resetUrl */

        $path = parse_url($resetUrl, PHP_URL_PATH) ?: '';
        $segments = explode('/', trim($path, '/'));
        $token = end($segments);

        $this->post(route('password.store'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'PasswordBaru123!',
            'password_confirmation' => 'PasswordBaru123!',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('PasswordBaru123!', $user->fresh()->password));
    }
}