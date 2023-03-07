<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Provinsi\Provinsi;

interface ProvinsiRepositoryInterface
{
    /**
     * @return Provinsi[]
     */
    public function getAll(): array;

    public function find(int $id): ?Provinsi;
}
