<?php

namespace App\Http\Controllers;

use App\Enums\PetStatus;
use App\Services\ApiErrorService;
use App\Services\ApiService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class PetApiController
 */
class PetApiController extends Controller
{
    /**
     * @var ApiService $apiService
     */
    protected ApiService $apiService;

    /**
     * @var string $url
     */
    private string $url;

    /**
     * @var ApiErrorService
     */
    private ApiErrorService $apiErrorService;

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->apiErrorService = new ApiErrorService();
        $this->url = env('PETS_API_URL');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'photoUrls' => 'required|array',
            'status' => 'required|in:' .
                PetStatus::AVAILABLE . ',' .
                PetStatus::PENDING . ',' .
                PetStatus::SOLD,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

        try {
            $response = $this->apiService->makePostRequest($this->url, $request->all());

            $responseData = json_decode($response->getBody()->getContents(), true);
            $httpStatus = $response->getStatusCode();

            return response()->json($responseData, $httpStatus, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return $this->apiErrorService->handleErrorResponse($e);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $response = $this->apiService->makeGetRequest($this->url . $id);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $httpStatus = $response->getStatusCode();

            return response()->json($responseData, $httpStatus, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return $this->apiErrorService->handleErrorResponse($e);
        }
    }

    /**
     * @param string $status
     * @return JsonResponse
     */
    public function findByStatus(string $status): JsonResponse
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|in:' .
                PetStatus::AVAILABLE . ',' .
                PetStatus::PENDING . ',' .
                PetStatus::SOLD,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

        try {
            $response = $this->apiService->makeGetRequest($this->url . 'findByStatus?status=' . $status);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $httpStatus = $response->getStatusCode();

            return response()->json($responseData, $httpStatus, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return $this->apiErrorService->handleErrorResponse($e);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

        try {
            $response = $this->apiService->makePutRequest($this->url, $request->all());

            $responseData = json_decode($response->getBody()->getContents(), true);
            $httpStatus = $response->getStatusCode();

            return response()->json($responseData, $httpStatus, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return $this->apiErrorService->handleErrorResponse($e);
        }

    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $response = $this->apiService->makeDeleteRequest($this->url . $id);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $httpStatus = $response->getStatusCode();

            return response()->json($responseData, $httpStatus, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return $this->apiErrorService->handleErrorResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadPetImage(Request $request): JsonResponse
    {
        try {
            $response = $this->apiService->handleUploadImageRequest($request, $this->url);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $httpStatus = $response->getStatusCode();

            return response()->json($responseData, $httpStatus, [], JSON_PRETTY_PRINT);
        } catch (RequestException|GuzzleException $e) {
            return $this->apiErrorService->handleErrorResponse($e);
        }
    }
}
