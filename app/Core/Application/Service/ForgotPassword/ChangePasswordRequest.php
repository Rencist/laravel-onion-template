<?php

namespace App\Core\Application\Service\ForgotPassword;

class ChangePasswordRequest
{
    private string $token;
    private string $password;
    private string $re_password;

    public function __construct(string $token, string $password, string $re_password)
    {
        $this->token = $token;
        $this->password = $password;
        $this->re_password = $re_password;
    }

    /**
     * Get the value of token
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the value of re_password
     */
    public function getRepassword()
    {
        return $this->re_password;
    }
}