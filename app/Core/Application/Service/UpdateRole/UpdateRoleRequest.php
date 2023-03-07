<?php

namespace App\Core\Application\Service\UpdateRole;

class UpdateRoleRequest
{
    private int $id;
    private string $name;

    /**
     * @param int $id
     * @param string $name
     */

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
