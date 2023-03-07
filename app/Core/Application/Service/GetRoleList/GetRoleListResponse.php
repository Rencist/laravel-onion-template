<?php

namespace App\Core\Application\Service\GetRoleList;

use JsonSerializable;
use App\Core\Domain\Models\Role\Role;

class GetRoleListResponse implements JsonSerializable
{
    private Role $role;

    /**
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->role->getId(),
            'role' => $this->role->getName(),
        ];
    }
}
