<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;

interface UserRepositoryInterface
{
    public function persist(User $user): void;

    public function delete(UserId $id): void;

    public function find(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function findByRoleId(int $role_id): ?array;

    public function getWithPagination(int $page, int $per_page): array;

    public function constructFromRows(array $rows): array;
}
