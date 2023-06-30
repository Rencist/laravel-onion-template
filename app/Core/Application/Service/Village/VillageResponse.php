<?php

namespace App\Core\Application\Service\Village;

use JsonSerializable;

class VillageResponse implements JsonSerializable
{
    private int $id;
    private int $subdistrict_id;
    private string $name;

    /**
     * @param int $id
     * @param int $subdistrict_id
     * @param string $name
     */
    public function __construct(int $id, int $subdistrict_id, string $name)
    {
        $this->id = $id;
        $this->subdistrict_id = $subdistrict_id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'subdistrict_id' => $this->subdistrict_id,
            'name' => $this->name,
        ];
    }
}
