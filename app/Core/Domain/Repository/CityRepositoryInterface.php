<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\City\City;

interface CityRepositoryInterface
{
    /**
     * @param string $id
     * @return City[]
     */
    public function getAll(): array;

    public function getByProvinceId(int $province_id): array;

    public function find(int $id): ?City;
}
