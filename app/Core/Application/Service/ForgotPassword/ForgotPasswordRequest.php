<?php

namespace App\Core\Application\Service\ForgotPassword;

use App\Core\Domain\Models\Email;

class ForgotPasswordRequest
{
    private Email $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
}
