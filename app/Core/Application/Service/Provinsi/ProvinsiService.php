<?php

namespace App\Core\Application\Service\Provinsi;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Provinsi\Provinsi;
use App\Core\Domain\Repository\ProvinsiRepositoryInterface;

class ProvinsiService
{
    private ProvinsiRepositoryInterface $provinsi_repository;

    /**
     * @param ProvinsiRepositoryInterface $provinsi_repository
     */
    public function __construct(ProvinsiRepositoryInterface $provinsi_repository)
    {
        $this->provinsi_repository = $provinsi_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(): array
    {
        $provinsi = $this->provinsi_repository->getAll();
        if (count($provinsi) < 1) {
            UserException::throw("Provinsi Tidak Ditemukan", 1059, 404);
        }
        return array_map(function (Provinsi $result) {
            return new ProvinsiResponse(
                $result->getId(),
                $result->getName()
            );
        }, $provinsi);
    }
}
