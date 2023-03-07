<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Kabupaten\KabupatenService;

class KabupatenController extends Controller
{
    public function kabupaten(Request $request, KabupatenService $service): JsonResponse
    {
        $response = $service->execute($request['provinsi_id']);
        return $this->successWithData($response, "Berhasil Mengambil Data Kabupaten");
    }
}
