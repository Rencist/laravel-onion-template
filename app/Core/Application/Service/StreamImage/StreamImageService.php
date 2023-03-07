<?php

namespace App\Core\Application\Service\StreamImage;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function end;
use function filemtime;
use function gmdate;
use function storage_path;
use function time;

class StreamImageService
{
    public function execute(StreamImageRequest $request): StreamedResponse
    {
        $array_prefixes = preg_split('/\//', $request->getPath());
        return Storage::download(
            $request->getPath(),
            end($array_prefixes),
            [
                'Pragma' => 'public',
                'Cache-Control' => 'max-age=2628000, public',
                'Expires' => gmdate(DATE_RFC1123, time() + 2628000) . ' GMT',
                'Last-Modified' => gmdate(
                    DATE_RFC1123,
                    @filemtime(storage_path("app/" . $request->getPath()))
                ) . ' GMT',
            ]
        );
    }
}
