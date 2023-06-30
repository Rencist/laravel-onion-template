<?php

namespace App\Core\Application\Service\GetRolePermission;

use JsonSerializable;

class GetRolePermissionResponse implements JsonSerializable
{
    private int $id;
    private string $route;

    /**
     * @param int $id
     * @param string $route
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->route = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'route' => $this->route,
        ];
    }
}
