<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PatientResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly string $token)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = URL::route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        $expireMinutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject('Reset Kata Sandi Akun Puskesmas')
            ->greeting('Halo '.$notifiable->name.',')
            ->line('Kami menerima permintaan untuk mereset kata sandi akun Anda di Sistem Antrian Puskesmas Mapurujaya.')
            ->line('Klik tombol di bawah ini untuk membuka halaman reset dan membuat kata sandi baru.')
            ->action('Buka Halaman Reset Password', $resetUrl)
            ->line('Link reset ini berlaku selama '.$expireMinutes.' menit.')
            ->line('Setelah halaman terbuka, masukkan kata sandi baru dan simpan perubahan Anda.')
            ->line('Jika Anda tidak meminta reset kata sandi, abaikan email ini.')
            ->salutation('Salam, Sistem Antrian Puskesmas');
    }
}
