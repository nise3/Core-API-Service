<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\CustomExceptionHandler;
use App\Models\LocDistrict;
use App\Services\LocationManagementServices\LocDistrictService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Psy\Util\Json;
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
     * @return \Exception|JsonResponse|Throwable
     */
    public function getList(Request $request):JsonResponse
    {
        try {
            $response = $this->locDistrictService->getAllDistricts($request, $this->startTime);
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function read(Request $request, int $id):JsonResponse
    {
        try {
            $response = $this->locDistrictService->getOneDistrict($id, $this->startTime);
        } catch (Throwable $e) {
          return $e;
        }
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function store(Request $request):JsonResponse
    {
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
          return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id):JsonResponse
    {
        $locDistrict = LocDistrict::findOrFail($id);
        $validated = $this->locDistrictService->validator($request,$id)->validate();
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
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function destroy(int $id):JsonResponse
    {
        $locDistrict = LocDistrict::findOrFail($id);
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
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
