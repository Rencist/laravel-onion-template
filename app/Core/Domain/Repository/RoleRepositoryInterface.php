<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Role\Role;

interface RoleRepositoryInterface
{
    public function persist(Role $role): void;

    public function delete(int $id): void;

    public function find(int $id): ?Role;

    public function findLargestId(): ?int;

    public function getWithPagination(int $page, int $per_page): array;
}
