<?php

namespace App\Core\Domain\Models\Permission;

use Exception;

class Permission
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

    /**
     * @throws Exception
     */
    public static function create(string $routes, int $id): self
    {
        return new self(
            $id,
            $routes,
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
     * @return string
     */
    public function getRoutes(): string
    {
        return $this->routes;
    }
}
