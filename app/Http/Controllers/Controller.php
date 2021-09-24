<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *     title="API La Rifa Peru",
     *     version="1.0.0"
     * )
     *
     * @OA\SecurityScheme(
     *     type="http",
     *     description="login",
     *     name="token",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth"
     * )
     *
     * @OA\Server(
     *      url="http://larifa.com/api",
     *      description="La Rifa Perú API",
     *
     * @OA\ServerVariable(
     *      serverVariable="schema",
     *      enum={"https", "http"},
     *      default="http"
     *  )
     * )
     *
     * @OA\Server(
     *      url="http://127.0.0.1:8080/api",
     *      description="localhost8080",
     *
     * @OA\ServerVariable(
     *      serverVariable="schema",
     *      enum={"http"},
     *      default="http"
     *  )
     * )
     * @OA\Server(
     *      url="http://127.0.0.1/api",
     *      description="localhost",
     *
     * @OA\ServerVariable(
     *      serverVariable="schema",
     *      enum={"http"},
     *      default="http"
     *  )
     * )
     *
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
