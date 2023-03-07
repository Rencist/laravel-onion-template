<?php

namespace App\Core\Domain\Models\Kabupaten;

class Kabupaten
{
    private int $id;
    private int $provinsi_id;
    private string $name;

    /**
     * @param int $id
     * @param int $provinsi_id
     * @param string $name
     */
    public function __construct(int $id, int $provinsi_id, string $name)
    {
        $this->id = $id;
        $this->provinsi_id = $provinsi_id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getProvinsiId(): int
    {
        return $this->provinsi_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
