<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Provinsi\Provinsi;
use App\Core\Domain\Repository\ProvinsiRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlProvinsiRepository implements ProvinsiRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('provinsi')->get();

        return $this->constructFromRows($rows->all());
    }

        public function find(int $id): ?Provinsi
        {
            $row = DB::table('provinsi')->where('id', $id)->first();

            return $this->constructFromRows([$row])[0];
        }

    /**
         * @param array $rows
         * @return Provinsi[]
         * @throws Exception
         */
    public function constructFromRows(array $rows): array
    {
        $provinsi = [];
        foreach ($rows as $row) {
            $provinsi[] = new Provinsi(
                $row->id,
                $row->name,
            );
        }
        return $provinsi;
    }
}
