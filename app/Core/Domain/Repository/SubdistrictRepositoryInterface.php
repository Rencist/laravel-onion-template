<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Subdistrict\Subdistrict;

interface SubdistrictRepositoryInterface
{
    /**
     * @param string $id
     * @return Subdistrict[]
     */
    public function getAll(): array;

    public function getByCityId(int $city_id): array;

    public function find(int $id): ?Subdistrict;
}
