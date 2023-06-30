<?php

namespace App\Core\Domain\Models\User;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;

class User
{
    private UserId $id;
    private int $role_id;
    private Email $email;
    private string $name;
    private string $hashed_password;
    private static bool $verifier = false;

    /**
     * @param UserId $id
     * @param int $role_id
     * @param Email $email
     * @param string $name
     * @param string $hashed_password
     */
    public function __construct(UserId $id, int $role_id, Email $email, string $name, string $hashed_password)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->email = $email;
        $this->name = $name;
        $this->hashed_password = $hashed_password;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public static function isVerifier(): bool
    {
        return self::$verifier;
    }


    public function beginVerification(): self
    {
        self::$verifier = true;
        return $this;
    }

    public function checkPassword(string $password): self
    {
        self::$verifier &= Hash::check($password, $this->hashed_password);
        return $this;
    }

    public function checkRoleId(string $role_id): self
    {
        self::$verifier &= ($this->role_id == $role_id);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function verify(): void
    {
        if (!self::$verifier) {
            UserException::throw("Username Atau Password Salah", 1003, 401);
        }
    }

    /**
     * @throws Exception
     */
    public static function create(int $role_id, Email $email, string $name, string $unhashed_password): self
    {
        return new self(
            UserId::generate(),
            $role_id,
            $email,
            $name,
            Hash::make($unhashed_password)
        );
    }

    /**
    * @throws Exception
    */
    public function changePassword(string $unhashed_password) : void
    {
        $this->hashed_password = Hash::make($unhashed_password);
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->role_id;
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
    public function getHashedPassword(): string
    {
        return $this->hashed_password;
    }
}
