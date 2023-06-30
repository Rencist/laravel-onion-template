<?php

namespace App\Core\Domain\Models\Subdistrict;

class Subdistrict
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
    public function getCityId(): int
    {
        return $this->city_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
