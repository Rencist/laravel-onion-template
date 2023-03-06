<?php

namespace App\Core\Application\Service\LoginUser;

use App\Core\Domain\Models\User\UserType;
use JsonSerializable;

class LoginUserResponse implements JsonSerializable
{
    private string $token_jwt;
    private UserType $user_type;

    /**
     * @param string $token_jwt
     */
    public function __construct(string $token_jwt, UserType $user_type)
    {
        $this->token_jwt = $token_jwt;
        $this->user_type = $user_type;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token_jwt,
            'user_type' => $this->user_type
        ];
    }
}
