<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientRegistrationOtpNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $otp)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode OTP Aktivasi Akun Puskesmas')
            ->greeting('Halo ' . ($notifiable->name ?? 'Pasien') . ',')
            ->line('Terima kasih sudah mendaftar. Masukkan kode OTP berikut untuk aktivasi akun:')
            ->line('Kode OTP: ' . $this->otp)
            ->line('Kode berlaku selama 10 menit.')
            ->line('Jika Anda tidak merasa mendaftar, abaikan email ini.');
    }
}
