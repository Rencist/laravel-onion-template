<?php

namespace App\Core\Domain\Models\AccountVerification;

use Exception;
use App\Core\Domain\Models\Email;

class AccountVerification
{
    private AccountVerificationId $id;
    private Email $email;
    private string $token;
    private bool $is_active;

    /**
     * @param AccountVerificationId $id
     * @param Email $email
     * @param string $token
     * @param bool $is_active
     */
    public function __construct(AccountVerificationId $id, Email $email, string $token, bool $is_active)
    {
        $this->id = $id;
        $this->email = $email;
        $this->token = $token;
        $this->is_active = $is_active;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @throws Exception
     */
    public static function create(Email $email, string $token): self
    {
        return new self(
            AccountVerificationId::generate(),
            $email,
            $token,
            false
        );
    }

    /**
     * @return AccountVerificationId
     */
    public function getId(): AccountVerificationId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @return void
     */
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }
}
