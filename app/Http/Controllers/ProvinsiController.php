<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Provinsi\ProvinsiService;

class ProvinsiController extends Controller
{
    /**
     * @throws Exception
     */
    public function provinsi(ProvinsiService $service): JsonResponse
    {
        $response = $service->execute();
        return $this->successWithData($response, "Berhasil Mengambil Data Provinsi");
    }
}
