<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Subdistrict\Subdistrict;
use App\Core\Domain\Repository\SubdistrictRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SqlSubdistrictRepository implements SubdistrictRepositoryInterface
{
    public function getAll(): array
    {
        $rows = DB::table('subdistricts')->get();
        return $this->constructFromRows($rows->all());
    }

    public function getByCityId(int $city_id): array
    {
        $row = DB::table('subdistricts')->where('cities_id', '=', $city_id)->get();
        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?Subdistrict
    {
        $row = DB::table('subdistricts')->where('id', $id)->first();
        return $this->constructFromRows([$row])[0];
    }

    public function constructFromRows(array $rows): array
    {
        $subdistrict = [];
        foreach ($rows as $row) {
            $subdistrict[] = new Subdistrict(
                $row->id,
                $row->cities_id,
                $row->name,
            );
        }
        return $subdistrict;
    }
}
