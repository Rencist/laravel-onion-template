<?php

namespace App\Core\Application\Service\Subdistrict;

use JsonSerializable;

class SubdistrictResponse implements JsonSerializable
{
    private int $id;
    private int $city_id;
    private string $name;

    /**
     * @param int $id
     * @param int $city_id
     * @param string $name
     */
    public function __construct(int $id, int $city_id, string $name)
    {
        $this->id = $id;
        $this->city_id = $city_id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'city_id' => $this->city_id,
            'name' => $this->name,
        ];
    }
}
