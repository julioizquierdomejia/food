<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse("No se encontro la URL especificada", 404);
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse('El método especificado no es valido', 405);
            } elseif ($e instanceof HttpException) {
                return $this->errorResponse($e->getMessage(), $e->getStatusCode());
            } elseif ($e instanceof \Exception) {
                return $this->errorResponse('Error inesperado por favor consulte al administrador del sistema.', 500);
            }
        }

        return parent::render($request, $e);
    }
}
