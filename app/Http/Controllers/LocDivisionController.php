<?php

namespace App\Http\Controllers;

use App\Models\LocDivision;
use App\Services\LocationManagementServices\LocDivisionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class LocDivisionController extends Controller
{
    /**
     * @var LocDivisionService
     */
    public LocDivisionService $locDivisionService;
    public Carbon $startTime;

    /**
     * LocDivisionController constructor.
     * @param LocDivisionService $locDivisionService
     * @param Carbon $startTime
     */
    public function __construct(LocDivisionService $locDivisionService, Carbon $startTime)
    {
        $this->locDivisionService = $locDivisionService;
        $this->startTime = $startTime;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException|AuthorizationException
     */
    public function getList(Request $request): JsonResponse
    {

        //$this->authorize('viewAny', LocDivision::class);

        $filter = $this->locDivisionService->filterValidator($request)->validate();

        try {
            $response = $this->locDivisionService->getAllDivisions($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(Request $request, int $id)
    {
        try {
            $division = $this->locDivisionService->getOneDivision($id);
            if (!$division) {
                abort(ResponseAlias::HTTP_NOT_FOUND);
            }
            //$this->authorize('view', $division);

            $response = [
                "data" => $division ?: null,
                "_response_status" => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "query_time" => $this->startTime->diffForHumans(Carbon::now())
                ]
            ];
            return Response::json( $response);
        } catch (Throwable $e) {
            throw $e;
        }

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', LocDivision::class);

        $validated = $this->locDivisionService->validator($request)->validate();
        try {
            $loc_division = $this->locDivisionService->store($validated);
            $response = [
                'data' => $loc_division,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Division added successfully",
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
        $locDivision = LocDivision::findOrFail($id);

        $this->authorize('update', $locDivision);

        $validated = $this->locDivisionService->validator($request, $id)->validate();
        try {
            $loc_division = $this->locDivisionService->update($validated, $locDivision);
            $response = [
                'data' => $loc_division,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Division updated successfully",
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
        $locDivision = LocDivision::findOrFail($id);

        $this->authorize('delete', $locDivision);
        try {

            $this->locDivisionService->destroy($locDivision);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Division deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
