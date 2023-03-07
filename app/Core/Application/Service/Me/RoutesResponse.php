<?php

namespace App\Core\Application\Service\Me;

use JsonSerializable;

class RoutesResponse implements JsonSerializable
{
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}
