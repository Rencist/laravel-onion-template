<?php

namespace App\Core\Domain\Models\City;

class City
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
    public function getProvinceId(): int
    {
        return $this->province_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
