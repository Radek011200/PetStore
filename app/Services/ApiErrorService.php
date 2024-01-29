<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Exception;

class ApiErrorService
{
    /**
     * @param Exception $e
     * @return JsonResponse
     */
    public function handleErrorResponse(Exception $e): JsonResponse
    {
        $errorMessage = $e->getMessage();
        $httpStatus = 500;
        if ($e instanceof RequestException && $e->getResponse()) {
            $httpStatus = $e->getResponse()->getStatusCode();
        }

        return response()->json(['error' => $errorMessage], $httpStatus);
    }
}
