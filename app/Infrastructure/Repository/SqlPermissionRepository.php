<?php

namespace App\Infrastructure\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class SqlPermissionRepository implements PermissionRepositoryInterface
{
    public function persist(Permission $permissions): void
    {
        DB::table('permissions')->upsert([
            'id' => $permissions->getId(),
            'name' => $permissions->getName(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Permission
    {
        $row = DB::table('permissions')->where('id', $id)->first();

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
            $row->name,
        );
    }

    /**
     * @throws Exception
     */
    public function findLargestId(): ?int
    {
        $row = DB::table('permissions')->max('id');

        if (!$row) {
            return null;
        }

        return $row;
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('permissions')
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
        $rows = DB::table('permissions')->get();

        return $this->constructFromRows($rows->all());
    }

    private function constructFromRows(array $rows): array
    {
        $permissions = [];
        foreach ($rows as $row) {
            $permissions[] = new Permission(
                $row->id,
                $row->name,
            );
        }
        return $permissions;
    }

    public function delete(int $id): void
    {
        DB::table('permissions')->where('id', $id)->delete();
    }
}
