<?php

namespace App\Core\Application\Service\DeleteRole;

class DeleteRoleRequest
{
    private int $role_id;

    /**
     * @param int $role_id
     */

    public function __construct(int $role_id)
    {
        $this->role_id = $role_id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }
}
