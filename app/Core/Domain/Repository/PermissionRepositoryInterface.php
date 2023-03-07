<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Permission\Permission;

interface PermissionRepositoryInterface
{
    public function persist(Permission $permission): void;

    public function delete(int $id): void;

    public function find(int $id): ?Permission;

    public function findLargestId(): ?int;

    public function getWithPagination(int $page, int $per_page): array;

    public function getAll(): array;
}
