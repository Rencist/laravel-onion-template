<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\User\User;
use JsonSerializable;

class MeResponse implements JsonSerializable
{
    private User $user;
    private string $role;
    private array $routes;

    /**
     * @param User $user
     * @param string $role
     * @param array $routes
     */
    public function __construct(User $user, string $role, array $routes)
    {
        $this->user = $user;
        $this->role = $role;
        $this->routes = $routes;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString(),
            'no_telp' => $this->user->getNoTelp(),
            'permission' => [
                'role_id' => $this->user->getRoleId(),
                'role' => $this->role,
                'routes' => $this->routes,
            ]
        ];
        return $response;
    }
}
