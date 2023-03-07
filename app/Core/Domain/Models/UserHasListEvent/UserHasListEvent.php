<?php

namespace App\Core\Domain\Models\UserHasListEvent;

use App\Core\Domain\Models\User\UserId;
use Exception;

class UserHasListEvent
{
    private int $list_event_id;
    private UserId $user_id;

    /**
     * @param int $list_event_id
     * @param UserId $user_id
     */
    public function __construct(int $list_event_id, UserId $user_id)
    {
        $this->list_event_id = $list_event_id;
        $this->user_id = $user_id;
    }

    /**
     * @throws Exception
     */
    public static function create(int $list_event_id, UserId $user_id): self
    {
        return new self(
            $list_event_id,
            $user_id,
        );
    }

    /**
     * @return int
     */
    public function getListEventId(): int
    {
        return $this->list_event_id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
    }
}
