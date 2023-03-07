<?php

namespace App\Core\Application\Service\GetUserList;

use JsonSerializable;
use App\Core\Domain\Models\User\User;

class GetUserListResponse implements JsonSerializable
{
    private User $user;
    private string $role;

    /**
     * @param User $user
     * @param string $role
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId()->toString(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString(),
            'no_telp' => $this->user->getNoTelp(),
            'role' => $this->role,
        ];
    }
}
