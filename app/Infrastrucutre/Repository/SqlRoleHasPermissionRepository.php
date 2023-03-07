<?php

namespace App\Infrastrucutre\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class SqlRoleHasPermissionRepository implements RoleHasPermissionRepositoryInterface
{
    public function persist(RoleHasPermission $role_has_permission): void
    {
        DB::table('role_has_permission')->upsert([
            'id' => $role_has_permission->getId(),
            'role_id' => $role_has_permission->getRoleId(),
            'permission_id' => $role_has_permission->getPermissionId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findByRoleId(int $role_id): ?array
    {
        $row = DB::table('role_has_permission')->where('role_id', $role_id)->get();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows($row->all());
    }

    /**
     * @throws Exception
     */
    public function findByPermissionId(int $permission_id): ?array
    {
        $rows = DB::table('role_has_permission')->where('permission_id', $permission_id)->get();

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
                $row->role_id,
                $row->permission_id,
            );
        }
        return $role_has_permissions;
    }

    /**
     * @throws Exception
     */
    public function findLargestId(): ?int
    {
        $row = DB::table('role_has_permission')->max('id');

        if (!$row) {
            return null;
        }

        return $row;
    }

    public function delete(int $id): void
    {
        DB::table('role_has_permission')->where('id', $id)->delete();
    }

    public function findByBoth(int $role_id, int $permission_id): ?RoleHasPermission
    {
        $row = DB::table('role_has_permission')
            ->where('role_id', $role_id)
            ->where('permission_id', $permission_id)
            ->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getPermissionByRole(int $role_id): ?array
    {
        $permission = [];
        $raw = DB::table('role_has_permission')
        ->leftJoin('permission', 'role_has_permission.permission_id', '=', 'permission.id')
        ->where('role_id', '=', $role_id)
        ->get(['permission.id', 'routes']);

        foreach ($raw as $r) {
            array_push($permission, $r);
        }

        if (!$raw) {
            return null;
        }

        return $permission;
    }
}
