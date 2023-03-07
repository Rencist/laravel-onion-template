<?php

namespace App\Core\Application\Service\DeleteRoleHasPermission;

class DeleteRoleHasPermissionRequest
{
    private int $role_id;
    private int $permission_id;

    /**
     * @param int $role_id
     * @param int $permission_id
     */

    public function __construct(int $role_id, int $permission_id)
    {
        $this->role_id = $role_id;
        $this->permission_id = $permission_id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getPermissionId(): int
    {
        return $this->permission_id;
    }
}
