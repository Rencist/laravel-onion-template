<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class SqlPermissionRepository implements PermissionRepositoryInterface
{
    public function persist(Permission $permission): void
    {
        DB::table('permission')->upsert([
            'id' => $permission->getId(),
            'routes' => $permission->getRoutes(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Permission
    {
        $row = DB::table('permission')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): Permission
    {
        return new Permission(
            $row->id,
            $row->routes,
        );
    }

    /**
     * @throws Exception
     */
    public function findLargestId(): ?int
    {
        $row = DB::table('permission')->max('id');

        if (!$row) {
            return null;
        }

        return $row;
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('permission')
            ->paginate($per_page, ['*'], 'permission_page', $page);
        $permissions = [];

        foreach ($rows as $row) {
            $permissions[] = $this->constructFromRow($row);
        }
        return [
            "data" => $permissions,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function getAll(): array
    {
        $rows = DB::table('permission')->get();

        return $this->constructFromRows($rows->all());
    }

    private function constructFromRows(array $rows): array
    {
        $permission = [];
        foreach ($rows as $row) {
            $permission[] = new Permission(
                $row->id,
                $row->routes,
            );
        }
        return $permission;
    }

    public function delete(int $id): void
    {
        DB::table('permission')->where('id', $id)->delete();
    }
}
