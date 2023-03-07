<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\PasswordReset\PasswordReset;

interface PasswordResetRepositoryInterface
{
    public function persist(PasswordReset $password_reset): void;

    public function delete(string $email): void;

    public function findByEmail(string $email): ?PasswordReset;
}
