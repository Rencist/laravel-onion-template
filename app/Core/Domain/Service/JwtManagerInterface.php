<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\User\User;

interface JwtManagerInterface
{
    public function createFromUser(User $user, String $ip): string;

    public function decode(string $jwt, String $ip): UserAccount;

    public function createForgotPasswordToken(User $user): array;

    public function decodeForgotPasswordToken(string $jwt): array;
}
