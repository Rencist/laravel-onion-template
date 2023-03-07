<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;

interface RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $RoleHasPermission): void;

    public function delete(int $id): void;

    public function find(int $id): ?RoleHasPermission;

    public function findByRoleId(int $role_id): ?array;

    public function findByPermissionId(int $permission_id): ?array;

    public function findLargestId(): ?int;

    public function findByBoth(int $role_id, int $permission_id): ?RoleHasPermission;

    public function getPermissionByRole(int $role_id): ?array;
}
