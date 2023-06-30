<?php

namespace App\Core\Application\Service\AddPermission;

class AddPermissionRequest
{
    private string $name;

    /**
     * @param string $name
     */

     public function __construct(string $name)
     {
        $this->name = $name;
     }

     public function getName(): string
     {
        return $this->name;
     }
}