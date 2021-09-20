<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data)
    {
        return response()->json($data, 200);
    }

    protected function createResponse($data)
    {
        return response()->json($data, 201);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
