<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $name;

    public function __construct(string $otp, string $name = '')
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    public function build()
    {
        // config() (not env()) so this still resolves inside a queue worker
        // and when the config cache is warm.
        $appName = config('app.name', 'POROSKART');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name', $appName);

        return $this->subject('Your ' . $appName . ' verification code: ' . $this->otp)
            ->from($fromAddress, $fromName)
            ->replyTo($fromAddress, $fromName)
            ->view('frontend.mail.otp')
            ->text('frontend.mail.otp-text')
            ->with([
                'otp' => $this->otp,
                'name' => $this->name,
                'appName' => $appName,
            ]);
    }
}
