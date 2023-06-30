<?php

namespace App\Core\Application\Service\Village;

use App\Exceptions\UserException;
use App\Core\Domain\Models\Village\Village;
use App\Core\Domain\Repository\VillageRepositoryInterface;

class VillageService
{
    private VillageRepositoryInterface $city_repository;

    /**
     * @param VillageRepositoryInterface $city_repository
     */
    public function __construct(VillageRepositoryInterface $city_repository)
    {
        $this->city_repository = $city_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(?string $subdistrict_id): array
    {
        if ($subdistrict_id === null) {
            $allVillage = $this->city_repository->getAll();
            return array_map(function (Village $result) {
                return new VillageResponse(
                    $result->getId(),
                    $result->getSubdistrictId(),
                    $result->getName()
                );
            }, $allVillage);
        } else if ($subdistrict_id) {
            $allVillage = $this->city_repository->getBySubdistrictId($subdistrict_id);
            if (count($allVillage) < 1) {
                UserException::throw("Kelurahan Tidak Ditemukan", 1049, 404);
            } else {
                return array_map(function (Village $result) {
                    return new VillageResponse(
                        $result->getId(),
                        $result->getSubdistrictId(),
                        $result->getName()
                    );
                }, $allVillage);
            }
        }
    }
}
