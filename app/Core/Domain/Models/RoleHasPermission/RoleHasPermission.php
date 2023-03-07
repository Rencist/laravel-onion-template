<?php

namespace App\Core\Domain\Models\RoleHasPermission;

use Exception;

class RoleHasPermission
{
    private int $id;
    private int $role_id;
    private int $permission_id;

    /**
     * @param int $role_id
     * @param int $permission_id
     * @param int $id
     */
    public function __construct(int $id, int $role_id, int $permission_id)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->permission_id = $permission_id;
    }

    /**
     * @throws Exception
     */
    public static function create(int $id, int $role_id, int $permission_id): self
    {
        return new self(
            $id,
            $role_id,
            $permission_id,
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    /**
     * @return int
     */
    public function getPermissionId(): int
    {
        return $this->permission_id;
    }
}
