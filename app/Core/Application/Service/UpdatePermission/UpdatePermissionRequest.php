<?php

namespace App\Core\Application\Service\UpdatePermission;

class UpdatePermissionRequest
{
    private int $id;
    private string $routes;

    /**
     * @param int $id
     * @param string $routes
     */

    public function __construct(int $id, string $routes)
    {
        $this->id = $id;
        $this->routes = $routes;
    }

    public function getRoutes(): string
    {
        return $this->routes;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
