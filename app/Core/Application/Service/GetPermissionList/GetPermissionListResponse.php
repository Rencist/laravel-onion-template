<?php

namespace App\Core\Application\Service\GetPermissionList;

use JsonSerializable;
use App\Core\Domain\Models\Permission\Permission;

class GetPermissionListResponse implements JsonSerializable
{
    private Permission $permission;

    /**
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->permission->getId(),
            'name' => $this->permission->getName(),
        ];
    }
}
