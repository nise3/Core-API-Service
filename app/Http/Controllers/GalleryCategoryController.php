<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Services\ContentManagementServices\GalleryCategoryService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class GalleryCategoryController extends Controller
{

    public GalleryCategoryService $galleryCategoryService;
    private Carbon $startTime;


    public function __construct(GalleryCategoryService $galleryCategoryService)
    {
        $this->startTime = Carbon::now();
        $this->galleryCategoryService = $galleryCategoryService;
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
        $filter = $this->galleryCategoryService->filterValidator($request)->validate();

        try {
            $response = $this->galleryCategoryService->getAllGalleryCategories($filter, $this->startTime);
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
            $response = $this->galleryCategoryService->getOneGalleryCategory($id, $this->startTime);
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
        $validated = $this->galleryCategoryService->validator($request)->validate();
        try {
            $galleryCategory= $this->galleryCategoryService->store($validated);
            $response = [
                'data' => $galleryCategory,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "GalleryCategory added successfully",
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
        $galleryCategory = GalleryCategory::findOrFail($id);
        $validated = $this->galleryCategoryService->validator($request, $id)->validate();
        try {
            $galleryCategory = $this->galleryCategoryService->update($galleryCategory, $validated);
            $response = [
                'data' => $galleryCategory,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "GalleryCategory updated successfully",
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
        $galleryCategory = GalleryCategory::findOrFail($id);
        try {
            $this->galleryCategoryService->destroy($galleryCategory);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "GalleryCategory deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
