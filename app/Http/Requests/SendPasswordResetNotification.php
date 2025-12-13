<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendPasswordResetNotification extends Notification
{
    public string $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function via($notifiable): array {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage {
        $url = url("/reset-password?token={$this->token}&email={$notifiable->email}");

        return (new MailMessage)
            ->subject('Parolni Tiklash Havolasi')
            ->line('Siz parolni tiklash uchun so‘rov yubordingiz.')
            ->action('Parolni Tiklash', $url)
            ->line('Agar bu siz bo‘lmasangiz, bu xabarni e’tiborsiz qoldiring.');
    }
}
