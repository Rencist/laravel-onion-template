<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Village\Village;
use App\Core\Domain\Repository\VillageRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlVillageRepository implements VillageRepositoryInterface
{
    /**
     * @param int $subdistrict_id
     * @return Village[]
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('villages')->get();
        return $this->constructFromRows($rows->all());
    }

    public function getBySubdistrictId(int $subdistrict_id): array
    {
        $row = DB::table('villages')->where('subdistricts_id', '=', $subdistrict_id)->get();
        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?Village
    {
        $row = DB::table('villages')->where('id', $id)->first();
        return $this->constructFromRows([$row])[0];
    }

    /**
     * @param array $rows
     * @return Village[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $villages = [];
        foreach ($rows as $row) {
            $villages[] = new Village(
                $row->id,
                $row->subdistricts_id,
                $row->name,
            );
        }
        return $villages;
    }
}
