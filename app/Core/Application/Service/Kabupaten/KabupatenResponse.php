<?php

namespace App\Core\Application\Service\Kabupaten;

use JsonSerializable;

class KabupatenResponse implements JsonSerializable
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
