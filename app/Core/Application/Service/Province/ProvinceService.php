<?php

namespace App\Core\Application\Service\Province;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Province\Province;
use App\Core\Domain\Repository\ProvinceRepositoryInterface;

class ProvinceService
{
    private ProvinceRepositoryInterface $province_repository;

    /**
     * @param ProvinceRepositoryInterface $province_repository
     */
    public function __construct(ProvinceRepositoryInterface $province_repository)
    {
        $this->province_repository = $province_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(): array
    {
        $province = $this->province_repository->getAll();
        if (count($province) < 1) {
            UserException::throw("Provinsi Tidak Ditemukan", 1059, 404);
        }
        return array_map(function (Province $result) {
            return new ProvinceResponse(
                $result->getId(),
                $result->getName()
            );
        }, $province);
    }
}
