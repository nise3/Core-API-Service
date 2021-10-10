<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Services\ContentManagementServices\PartnerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class PartnerController extends Controller
{
    public PartnerService $partnerService;

    private Carbon $startTime;

    public function __construct(PartnerService $partnerService)
    {
        $this->startTime = Carbon::now();
        $this->partnerService = $partnerService;
    }


    /**
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->partnerService->filterValidation($request)->validate();
        try {
            $response = $this->partnerService->getPartnerList($filter, $this->startTime);
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
    public function read(Request $request,int $id):JsonResponse
    {
        try {
            $response = $this->partnerService->getOnePartner($id, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }


    /**
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $partner = new Partner();
        $validated = $this->partnerService->validator($request)->validate();
        try {
            $partner = $this->partnerService->store($partner, $validated);
            $response = [
                'data' => $partner,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Partner is added successfully",
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
        $partner = Partner::findOrFail($id);
        $validated = $this->partnerService->validator($request, $id)->validate();
        try {
            $partner = $this->partnerService->update($partner, $validated);
            $response = [
                'data' => $partner,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Partner Item is updated successfully",
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
        $partner = Partner::findOrFail($id);
        try {
            $this->partnerService->destroy($partner);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Partner deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
