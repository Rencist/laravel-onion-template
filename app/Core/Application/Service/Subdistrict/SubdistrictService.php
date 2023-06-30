<?php

namespace App\Core\Application\Service\Subdistrict;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Subdistrict\Subdistrict;
use App\Core\Domain\Repository\SubdistrictRepositoryInterface;

class SubdistrictService
{
    private SubdistrictRepositoryInterface $city_repository;

    /**
     * @param SubdistrictRepositoryInterface $city_repository
     */
    public function __construct(SubdistrictRepositoryInterface $city_repository)
    {
        $this->city_repository = $city_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?string $city_id): array
    {
        if ($city_id === null) {
            $allSubdistrict = $this->city_repository->getAll();
            return array_map(function (Subdistrict $result) {
                return new SubdistrictResponse(
                    $result->getId(),
                    $result->getCityId(),
                    $result->getName()
                );
            }, $allSubdistrict);
        } else if ($city_id) {
            $allSubdistrict = $this->city_repository->getByCityId($city_id);
            if (count($allSubdistrict) < 1) {
                UserException::throw("Kecamatan Tidak Ditemukan", 1049, 404);
            } else {
                return array_map(function (Subdistrict $result) {
                    return new SubdistrictResponse(
                        $result->getId(),
                        $result->getCityId(),
                        $result->getName()
                    );
                }, $allSubdistrict);
            }
        }
    }
}
