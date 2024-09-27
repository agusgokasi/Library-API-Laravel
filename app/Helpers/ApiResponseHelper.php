<?php

namespace App\Helpers;

class ApiResponseHelper
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'error' => null,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Error response
     *
     * @param string $errorMessage
     * @param int $statusCode
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($errorMessage = 'Error', $statusCode = 400, $data = null)
    {
        return response()->json([
            'status' => false,
            'message' => null,
            'error' => $errorMessage,
            'data' => $data
        ], $statusCode);
    }
}
