<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Kabupaten\Kabupaten;
use App\Core\Domain\Repository\KabupatenRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlKabupatenRepository implements KabupatenRepositoryInterface
{
    /**
     * @param int $provinsi_id
     * @return Kabupaten[]
     * @throws Exception
     */
    public function getAll(): array
    {
        $rows = DB::table('kabupaten')->get();
        return $this->constructFromRows($rows->all());
    }

    public function getByProvinsiId(int $provinsi_id): array
    {
        $row = DB::table('kabupaten')->where('provinsi_id', '=', $provinsi_id)->get();
        return $this->constructFromRows($row->all());
    }

    public function find(int $id): ?Kabupaten
    {
        $row = DB::table('kabupaten')->where('id', $id)->first();
        return $this->constructFromRows([$row])[0];
    }

    /**
     * @param array $rows
     * @return Kabupaten[]
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $kabupaten = [];
        foreach ($rows as $row) {
            $kabupaten[] = new Kabupaten(
                $row->id,
                $row->provinsi_id,
                $row->name,
            );
        }
        return $kabupaten;
    }
}
