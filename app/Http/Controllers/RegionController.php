<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\City\CityService;
use App\Core\Application\Service\Village\VillageService;
use App\Core\Application\Service\Province\ProvinceService;
use App\Core\Application\Service\Subdistrict\SubdistrictService;

class RegionController extends Controller
{
    public function getProvince(ProvinceService $service): JsonResponse
    {
        $response = $service->execute();
        return $this->successWithData($response, "Berhasil Mengambil Data Provinsi");
    }
    
    public function getCity(Request $request, CityService $service): JsonResponse
    {
        $response = $service->execute($request['province_id']);
        return $this->successWithData($response, "Berhasil Mengambil Data Kabupaten");
    }
    
    public function getSubdistrict(Request $request, SubdistrictService $service): JsonResponse
    {
        $response = $service->execute($request['city_id']);
        return $this->successWithData($response, "Berhasil Mengambil Data Kecamatan");
    }
    
    public function getVillage(Request $request, VillageService $service): JsonResponse
    {
        $response = $service->execute($request['subdistrict_id']);
        return $this->successWithData($response, "Berhasil Mengambil Data Kelurahan");
    }
}
