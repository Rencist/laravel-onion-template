<?php

namespace App\Core\Application\Service\City;

use JsonSerializable;

class CityResponse implements JsonSerializable
{
    private int $id;
    private int $province_id;
    private string $name;

    /**
     * @param int $id
     * @param int $province_id
     * @param string $name
     */
    public function __construct(int $id, int $province_id, string $name)
    {
        $this->id = $id;
        $this->province_id = $province_id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'province_id' => $this->province_id,
            'name' => $this->name,
        ];
    }
}
