<?php

namespace App\Core\Application\Service\ChangePassword;

class ChangePasswordRequest
{
    private string $email;
    private string $current_password;
    private string $new_password;
    private string $re_password;

    /**
     * @param string $email
     * @param string $currect_password
     * @param string $new_password
     * @param string $re_password
     */
    public function __construct(string $email, string $current_password, string $new_password, string $re_password)
    {
        $this->email = $email;
        $this->current_password = $current_password;
        $this->new_password = $new_password;
        $this->re_password = $re_password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCurrentPassword(): string
    {
        return $this->current_password;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->new_password;
    }

    /**
     * @return string
     */
    public function getRePassword(): string
    {
        return $this->re_password;
    }
}
