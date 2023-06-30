<?php

namespace App\Core\Application\Service\City;

use App\Exceptions\UserException;
use App\Core\Domain\Models\City\City;
use App\Core\Domain\Repository\CityRepositoryInterface;

class CityService
{
    private CityRepositoryInterface $city_repository;

    /**
     * @param CityRepositoryInterface $city_repository
     */
    public function __construct(CityRepositoryInterface $city_repository)
    {
        $this->city_repository = $city_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?string $province_id): array
    {
        if ($province_id === null) {
            $allCity = $this->city_repository->getAll();
            return array_map(function (City $result) {
                return new CityResponse(
                    $result->getId(),
                    $result->getProvinceId(),
                    $result->getName()
                );
            }, $allCity);
        } else if ($province_id) {
            $allCity = $this->city_repository->getByProvinceId($province_id);
            if (count($allCity) < 1) {
                UserException::throw("Kabupaten Tidak Ditemukan", 1049, 404);
            } else {
                return array_map(function (City $result) {
                    return new CityResponse(
                        $result->getId(),
                        $result->getProvinceId(),
                        $result->getName()
                    );
                }, $allCity);
            }
        }
    }
}
