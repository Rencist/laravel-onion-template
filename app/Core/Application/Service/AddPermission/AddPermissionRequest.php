<?php

namespace App\Core\Application\Service\AddPermission;

class AddPermissionRequest
{
    private string $routes;

    /**
     * @param string $routes
     */

     public function __construct(string $routes)
     {
        $this->routes = $routes;
     }

     public function getRoutes(): string
     {
        return $this->routes;
     }
}