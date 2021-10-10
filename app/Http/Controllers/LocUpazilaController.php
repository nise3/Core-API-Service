<?php

namespace App\Http\Controllers;


use App\Models\LocUpazila;

use App\Services\LocationManagementServices\LocUpazilaService;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class LocUpazilaController extends Controller
{
    /**
     * @var locUpazilaService
     */
    public LocUpazilaService $locUpazilaService;
    public Carbon $startTime;

    /**
     * LocUpazilaController constructor.
     * @param LocUpazilaService $locUpazilaService
     * @param Carbon $startTime
     */
    public function __construct(LocUpazilaService $locUpazilaService, Carbon $startTime)
    {
        $this->locUpazilaService = $locUpazilaService;
        $this->startTime = $startTime;
    }


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws AuthorizationException|ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        //$this->authorize('viewAny', LocUpazila::class);
        $filter = $this->locUpazilaService->filterValidator($request)->validate();

        try {
            $response = $this->locUpazilaService->getAllUpazilas($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(Request $request, int $id): JsonResponse
    {
        try {
            $response = $this->locUpazilaService->getOneUpazila($id, $this->startTime);
            if (!$response) {
                abort(ResponseAlias::HTTP_NOT_FOUND);
            }
            //$this->authorize('view', $response);
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
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', LocUpazila::class);
        $validated = $this->locUpazilaService->validator($request)->validate();
        try {
            $locUpazila = $this->locUpazilaService->store($validated);
            $response = [
                'data' => $locUpazila,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Upazila added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $locUpazila = LocUpazila::findOrFail($id);

        $this->authorize('update', $locUpazila);
        $validated = $this->locUpazilaService->validator($request, $id)->validate();
        try {
            $loc_upazila = $this->locUpazilaService->update($validated, $locUpazila);
            $response = [
                'data' => $loc_upazila,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Upazila updated successfully",
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
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $locUpazila = LocUpazila::findOrFail($id);

        $this->authorize('delete', $locUpazila);
        try {
            $this->locUpazilaService->destroy($locUpazila);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Upazila deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
