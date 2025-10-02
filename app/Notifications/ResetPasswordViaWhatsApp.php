<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ResetPasswordViaWhatsApp extends Notification
{
    use Queueable;

    public $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Kirim notifikasi melalui channel Twilio
        return [TwilioChannel::class];
    }

    /**
     * Definisikan pesan WhatsApp yang akan dikirim.
     */
    public function toTwilio(object $notifiable)
    {
        $appName = config('app.name');
        return (new TwilioSmsMessage())
            ->content("Anda menerima permintaan reset password untuk akun {$appName}. Klik link ini: {$this->url}\n\nLink akan kadaluarsa dalam 60 menit. Abaikan pesan ini jika Anda tidak merasa meminta reset password.");
    }
}