<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationOtpNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $otpCode, public int $expiresMinutes = 10)
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
        return (new MailMessage)
            ->subject('Mã OTP xác thực tài khoản')
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Mã OTP để kích hoạt tài khoản của bạn là:')
            ->line($this->otpCode)
            ->line('Mã này có hiệu lực trong ' . $this->expiresMinutes . ' phút.')
            ->line('Nếu bạn không yêu cầu đăng ký, hãy bỏ qua email này.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp_code' => $this->otpCode,
            'expires_minutes' => $this->expiresMinutes,
        ];
    }
}
