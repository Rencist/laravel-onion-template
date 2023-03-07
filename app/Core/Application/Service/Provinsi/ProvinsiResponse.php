<?php

namespace App\Core\Application\Service\Provinsi;

use JsonSerializable;

class ProvinsiResponse implements JsonSerializable
{
    private string $id;
    private string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
