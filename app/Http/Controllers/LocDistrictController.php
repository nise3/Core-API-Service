<?php

namespace App\Http\Controllers;

use App\Models\LocDistrict;
use App\Services\LocationManagementServices\LocDistrictService;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class LocDistrictController extends Controller
{
    /**
     * @var locDistrictService
     */
    public LocDistrictService $locDistrictService;
    private Carbon $startTime;

    /**
     * LocDistrictController constructor.
     * @param LocDistrictService $locDistrictService
     */
    public function __construct(LocDistrictService $locDistrictService)
    {
        $this->startTime = Carbon::now();

        $this->locDistrictService = $locDistrictService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function getList(Request $request): JsonResponse
    {
        //$this->authorize('viewAny', LocDistrict::class);
        $filter = $this->locDistrictService->filterValidator($request)->validate();
        try {

            $response = $this->locDistrictService->getAllDistricts($filter, $this->startTime);
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
            $response = $this->locDistrictService->getOneDistrict($id, $this->startTime);
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
        $this->authorize('create', LocDistrict::class);
        $validated = $this->locDistrictService->validator($request)->validate();
        try {
            $loc_district = $this->locDistrictService->store($validated);
            $response = [
                'data' => $loc_district,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "District added successfully",
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
     * @throws AuthorizationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $locDistrict = LocDistrict::findOrFail($id);
        $this->authorize('update', $locDistrict);
        $validated = $this->locDistrictService->validator($request, $id)->validate();
        try {
            $loc_district = $this->locDistrictService->update($locDistrict, $validated);
            $response = [
                'data' => $loc_district,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "District updated successfully",
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
        $locDistrict = LocDistrict::findOrFail($id);
        $this->authorize('delete', $locDistrict);
        try {

            $this->locDistrictService->destroy($locDistrict);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "District deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
