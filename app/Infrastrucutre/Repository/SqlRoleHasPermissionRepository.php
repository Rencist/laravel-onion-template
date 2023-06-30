<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class SqlRoleHasPermissionRepository implements RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $roles_has_permissions): void
    {
        DB::table('roles_has_permissions')->upsert([
            'id' => $roles_has_permissions->getId(),
            'roles_id' => $roles_has_permissions->getRoleId(),
            'permissions_id' => $roles_has_permissions->getPermissionId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?RoleHasPermission
    {
        $row = DB::table('roles_has_permissions')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findByRoleId(int $roles_id): ?array
    {
        $row = DB::table('roles_has_permissions')->where('roles_id', $roles_id)->get();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows($row->all());
    }

    /**
     * @throws Exception
     */
    public function findByPermissionId(int $permissions_id): ?array
    {
        $rows = DB::table('roles_has_permissions')->where('permissions_id', $permissions_id)->get();

        if (!$rows) {
            return null;
        }

        return $this->constructFromRows($rows->all());
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $role_has_permissions = [];
        foreach ($rows as $row) {
            $role_has_permissions[] = new RoleHasPermission(
                $row->id,
                $row->roles_id,
                $row->permissions_id,
            );
        }
        return $role_has_permissions;
    }

    /**
     * @throws Exception
     */
    public function findLargestId(): ?int
    {
        $row = DB::table('roles_has_permissions')->max('id');

        if (!$row) {
            return null;
        }

        return $row;
    }

    public function delete(int $id): void
    {
        DB::table('roles_has_permissions')->where('id', $id)->delete();
    }

    public function findByBoth(int $roles_id, int $permissions_id): ?RoleHasPermission
    {
        $row = DB::table('roles_has_permissions')
            ->where('roles_id', $roles_id)
            ->where('permissions_id', $permissions_id)
            ->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getPermissionByRole(int $roles_id): ?array
    {
        $permission = [];
        $raw = DB::table('roles_has_permissions')
        ->leftJoin('permissions', 'roles_has_permissions.permissions_id', '=', 'permissions.id')
        ->where('roles_id', '=', $roles_id)
        ->get(['permissions.id', 'name']);

        foreach ($raw as $r) {
            array_push($permission, $r);
        }

        if (!$raw) {
            return null;
        }

        return $permission;
    }
}
