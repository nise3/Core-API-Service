<?php

namespace App\Http\Controllers;


use App\Models\RecentActivity;
use App\Services\ContentManagementServices\RecentActivityService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class RecentActivityController extends Controller
{

    public RecentActivityService $recentActivityService;

    private Carbon $startTime;

    public function __construct(RecentActivityService $recentActivityService)
    {
        $this->startTime = Carbon::now();
        $this->recentActivityService = $recentActivityService;
    }

    /**
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->recentActivityService->filterValidator($request)->validate();
        try {
            $response = $this->recentActivityService->getRecentActivityList($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(int $id): JsonResponse
    {
        try {
            $response = $this->recentActivityService->getOneRecentActivity($id, $this->startTime);
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

        $validated = $this->recentActivityService->validator($request)->validate();
        try {
            $recentActivity = $this->recentActivityService->store($validated);
            $response = [
                'data' => $recentActivity,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Recent Activity added successfully",
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
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $recentActivity = RecentActivity::findOrFail($id);
        $validated = $this->recentActivityService->validator($request, $id)->validate();
        try {
            $recentActivity = $this->recentActivityService->update($recentActivity, $validated);
            $response = [
                'data' => $recentActivity,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Recent Activity updated successfully",
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
        $recentActivity = RecentActivity::findOrFail($id);
        try {
            $this->recentActivityService->destroy($recentActivity);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Recent Activity deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
