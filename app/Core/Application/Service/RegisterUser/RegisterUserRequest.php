<?php

namespace App\Core\Application\Service\RegisterUser;

class RegisterUserRequest
{
    private string $email;
    private string $name;
    private string $password;

    /**
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function __construct(string $email, string $name, string $password)
    {
        $this->email = $email;
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
