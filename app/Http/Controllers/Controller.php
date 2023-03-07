<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successWithData($data, $message): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => $message,
            ]
        );
    }

    protected function success($message): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
            ]
        );
    }
}
