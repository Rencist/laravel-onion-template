<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\User\User;
use JsonSerializable;

class MeResponse implements JsonSerializable
{
    private User $user;
    private string $role;
    private array $name;

    /**
     * @param User $user
     * @param string $role
     * @param array $name
     */
    public function __construct(User $user, string $role, array $name)
    {
        $this->user = $user;
        $this->role = $role;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString(),
            'permission' => [
                'role_id' => $this->user->getRoleId(),
                'role' => $this->role,
                'name' => $this->name,
            ]
        ];
        return $response;
    }
}
