<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\City\City;
use App\Core\Domain\Repository\CityRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlCityRepository implements CityRepositoryInterface
{
    /**
     * @param int $province_id
     * @return City[]
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('cities')->get();
        return $this->constructFromRows($rows->all());
    }

    public function getByProvinceId(int $province_id): array
    {
        $row = DB::table('cities')->where('provinces_id', '=', $province_id)->get();
        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?City
    {
        $row = DB::table('cities')->where('id', $id)->first();
        return $this->constructFromRows([$row])[0];
    }

    /**
     * @param array $rows
     * @return City[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $cities = [];
        foreach ($rows as $row) {
            $cities[] = new City(
                $row->id,
                $row->provinces_id,
                $row->name,
            );
        }
        return $cities;
    }
}
