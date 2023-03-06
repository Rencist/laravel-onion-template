<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;

interface UserRepositoryInterface
{
    public function persist(User $user): void;

    public function find(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;
}
