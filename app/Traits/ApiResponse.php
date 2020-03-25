<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * @param $data
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, $message, $code = Response::HTTP_OK)
    {
        return new JsonResponse([
            'data' => $data,
            'status' => [
                'message' => $message,
                'code' => $code
            ]
        ], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return new JsonResponse([
            'error' => $message,
            'code' => $code
        ], $code);
    }
}
