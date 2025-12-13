<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    protected function success($data = [], $message = 'Success', $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message = 'Error', $code = 400): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}

