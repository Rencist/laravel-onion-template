<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $request_id_code = "";
        if ($request) {
            // generating request unique id
            $mytime = Carbon::now();
            $time = $mytime->toDateTimeString();
            $request_id = $request->ip() . " " . $time;
            $request_id_code = Str::upper(Str::substr(md5($request_id), 0, 8));
        } else {
            $request_id_code = "None";
        }

        Log::error(
            date("Y-m-d H:i:s") . " " . $request_id_code . " " . $exception,
        );

        if ($exception instanceof UserException)
        {
            return $exception->render();
        }

        $code = 500;
        $message = "Terjadi Kesalahan Server";
        //$message = "Terjadi Kesalahan. Request Id: " . $request_id_code;
        if ($exception instanceof ValidationException) {
            $code = 422;
            $message = $exception->validator->errors()->first();
        }

        if ($exception instanceof ConnectionException) {
            $message = "Server is busy.";
        }

        if ($exception instanceof BadRequestException) {
            $code = 400;
            $message = $exception->getMessage();
        }

        if ($exception instanceof ModelNotFoundException) {
            $code = 404;
            $message = $exception->getMessage();
        }

        if ($exception instanceof NotFoundHttpException) {
            $code = 404;
            $message = $exception->getMessage();
        }

        if ($exception instanceof AuthenticationException) {
            $code = 401;
            $message = $exception->getMessage();
        }

        if (
            $exception instanceof AuthorizationException
        ) {
            $code = 403;
            $message = $exception->getMessage();
        }

        if(!App::environment('production')){
            $message = $exception->getMessage();
            $code = 500;
        }

        $content = [
            "code" => $code,
            "success" => false,
            "message" => $message,
        ];

        return response()->json(
            $content,
            $code,
            [],
            JSON_UNESCAPED_SLASHES
        );
    }
}
