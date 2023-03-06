<?php

namespace App\Core\Domain\Models\User;

enum UserType: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}
