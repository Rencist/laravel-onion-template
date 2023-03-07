<?php

namespace App\Core\Application\Service\DeletePermission;

class DeletePermissionRequest
{
    private int $permission_id;

    /**
     * @param int $permission_id
     */

    public function __construct(int $permission_id)
    {
        $this->permission_id = $permission_id;
    }

    public function getPermissionId(): int
    {
        return $this->permission_id;
    }
}
