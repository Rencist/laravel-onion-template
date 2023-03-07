<?php

namespace App\Core\Domain\Models\PasswordReset;

use App\Core\Domain\Models\Email;

class PasswordReset
{
    private Email $email;
    private string $token;

    /**
     * @param UserId $user_id
     */
    public function __construct(Email $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * Get the value of token
     */
    public function getToken(): String
    {
        return $this->token;
    }
}
