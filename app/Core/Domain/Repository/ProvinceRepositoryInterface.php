<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Province\Province;

interface ProvinceRepositoryInterface
{
    /**
     * @return Province[]
     */
    public function getAll(): array;

    public function find(int $id): ?Province;
}
