<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\StreamImage\StreamImageRequest;
use App\Core\Application\Service\StreamImage\StreamImageService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    public function streamImage(Request $request, StreamImageService $service): StreamedResponse
    {
        return $service->execute(new StreamImageRequest($request->input('path')));
    }
}
