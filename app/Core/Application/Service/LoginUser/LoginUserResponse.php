<?php

namespace App\Core\Application\Service\LoginUser;

use JsonSerializable;

class LoginUserResponse implements JsonSerializable
{
    private string $token_jwt;

    /**
     * @param string $token_jwt
     */
    public function __construct(string $token_jwt)
    {
        $this->token_jwt = $token_jwt;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token_jwt
        ];
    }
}
