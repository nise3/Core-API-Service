<?php

namespace App\Http\Controllers;

use App\Models\VideoCategory;
use App\Services\ContentManagementServices\VideoCategoryService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;
use Exception;

class VideoCategoryController extends Controller
{

    public VideoCategoryService $videoCategoryService;
    private Carbon $startTime;


    public function __construct(VideoCategoryService $videoCategoryService)
    {
        $this->startTime = Carbon::now();
        $this->videoCategoryService = $videoCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->videoCategoryService->filterValidator($request)->validate();

        try {
            $response = $this->videoCategoryService->getAllVideoCategories($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(int $id): JsonResponse
    {
        try {
            $response = $this->videoCategoryService->getOneVideoCategory($id, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->videoCategoryService->validator($request)->validate();
        try {
            $videoCategory = $this->videoCategoryService->store($validated);
            $response = [
                'data' => $videoCategory,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "VideoCategory added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $videoCategory = VideoCategory::findOrFail($id);
        $validated = $this->videoCategoryService->validator($request, $id)->validate();
        try {
            $videoCategory = $this->videoCategoryService->update($videoCategory, $validated);
            $response = [
                'data' => $videoCategory,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "VideoCategory updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $videoCategory = VideoCategory::findOrFail($id);
        try {
            $this->videoCategoryService->destroy($videoCategory);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "VideoCategory deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
