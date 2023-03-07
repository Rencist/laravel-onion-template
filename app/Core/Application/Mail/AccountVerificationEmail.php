<?php

namespace App\Core\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;

class AccountVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $email;
    private string $token;

    /**
     * @param string $email
     * @param string $token
     */
    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build(): AccountVerificationEmail
    {
        return $this->from(config('mail.from'))
            ->markdown('email.account_verification_email', [
                "email" => $this->email,
                "token" => $this->token,
            ]);
    }
}
