<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('respond')) {

    /**
     * description
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    function respond(string $message, int $status=200) : JsonResponse
    {
        return response()->json(['message' => $message], $status);
    }
}
