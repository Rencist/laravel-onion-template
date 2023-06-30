<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Village\Village;

interface VillageRepositoryInterface
{
    /**
     * @param string $id
     * @return Village[]
     */
    public function getAll(): array;

    public function getBySubdistrictId(int $subdistrict_id): array;

    public function find(int $id): ?Village;
}
