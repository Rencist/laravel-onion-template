<?php

namespace App\Core\Domain\Models\Village;

class Village
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
    public function getSubdistrictId(): int
    {
        return $this->subdistrict_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
