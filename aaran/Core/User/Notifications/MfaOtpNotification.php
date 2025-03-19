<?php

namespace Aaran\Core\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class MfaOtpNotification extends Notification
{
    use Queueable;

    protected string $otp;

    public function __construct()
    {
        // Generate a 6-digit OTP
        $this->otp = rand(100000, 999999);
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Store OTP in cache for 5 minutes
        Cache::put("mfa_otp_{$notifiable->id}", $this->otp, now()->addMinutes(5));

        return (new MailMessage)
            ->subject('Your MFA Code')
            ->line("Your One-Time Password (OTP) for login is: **{$this->otp}**")
            ->line('This OTP is valid for 5 minutes.');
    }
}
