<?php

namespace App\Core\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $token;

    /**
     * @param string $email
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function build(): RequestPasswordEmail
    {
        return $this->from(config('mail.from'))
            ->markdown('email.request_password_email', [
                "token" => $this->token,
            ]);
    }
}
