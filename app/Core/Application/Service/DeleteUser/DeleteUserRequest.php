<?php

namespace App\Core\Application\Service\DeleteUser;

class DeleteUserRequest
{
    private string $user_id;

    /**
     * @param string $user_id
     */

     public function __construct(string $user_id)
     {
        $this->user_id = $user_id;
     }

     public function getUserId(): string
     {
        return $this->user_id;
     }
}