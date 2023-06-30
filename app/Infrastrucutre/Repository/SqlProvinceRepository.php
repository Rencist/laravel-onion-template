<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Province\Province;
use App\Core\Domain\Repository\ProvinceRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlProvinceRepository implements ProvinceRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('provinces')->get();

        return $this->constructFromRows($rows->all());
    }

        public function find(int $id): ?Province
        {
            $row = DB::table('provinces')->where('id', $id)->first();

            return $this->constructFromRows([$row])[0];
        }

    /**
         * @param array $rows
         * @return Province[]
         * @throws Exception
         */
    public function constructFromRows(array $rows): array
    {
        $provinces = [];
        foreach ($rows as $row) {
            $provinces[] = new Province(
                $row->id,
                $row->name,
            );
        }
        return $provinces;
    }
}
