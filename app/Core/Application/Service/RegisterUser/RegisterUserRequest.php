<?php

namespace App\Core\Application\Service\RegisterUser;

class RegisterUserRequest
{
    private string $email;
    private string $no_telp;
    private string $name;
    private string $password;

    /**
     * @param string $email
     * @param string $no_telp
     * @param string $name
     * @param string $password
     */
    public function __construct(string $email, string $no_telp, string $name, string $password)
    {
        $this->email = $email;
        $this->no_telp = $no_telp;
        $this->name = $name;
        $this->password = $password;
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
    public function getNoTelp(): string
    {
        return $this->no_telp;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
