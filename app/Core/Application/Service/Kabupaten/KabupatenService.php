<?php

namespace App\Core\Application\Service\Kabupaten;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Kabupaten\Kabupaten;
use App\Core\Domain\Repository\KabupatenRepositoryInterface;

class KabupatenService
{
    private KabupatenRepositoryInterface $kabupaten_repository;

    /**
     * @param KabupatenRepositoryInterface $kabupaten_repository
     */
    public function __construct(KabupatenRepositoryInterface $kabupaten_repository)
    {
        $this->kabupaten_repository = $kabupaten_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?string $provinsi_id): array
    {
        if ($provinsi_id === null) {
            $allKabupaten = $this->kabupaten_repository->getAll();
            return array_map(function (Kabupaten $result) {
                return new KabupatenResponse(
                    $result->getId(),
                    $result->getName()
                );
            }, $allKabupaten);
        } elseif ($provinsi_id) {
            $allKabupaten = $this->kabupaten_repository->getByProvinsiId($provinsi_id);
            if (count($allKabupaten) < 1) {
                UserException::throw("Kabupaten dengan id provinsi tersebut tidak ditemukan", 1049, 404);
            } else {
                return array_map(function (Kabupaten $result) {
                    return new KabupatenResponse(
                        $result->getId(),
                        $result->getName()
                    );
                }, $allKabupaten);
            }
        }
    }
}
