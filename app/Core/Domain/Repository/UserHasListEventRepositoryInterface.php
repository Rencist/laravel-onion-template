<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\User\UserId;

interface UserHasListEventRepositoryInterface
{
    public function findByUserId(UserId $id): ?array;

    public function findByUserIdReturningOnlyEventsId(UserId $user_id): ?array;
}
