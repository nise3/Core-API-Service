<?php

namespace App\Http\Controllers;

use App\Models\NoticeOrNews;
use App\Services\ContentManagementServices\NoticeOrNewsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class NoticeOrNewsController extends Controller
{
    public NoticeOrNewsService $noticeOrNewsService;

    private Carbon $startTime;

    public function __construct(NoticeOrNewsService $noticeOrNewsService)
    {
        $this->startTime = Carbon::now();
        $this->noticeOrNewsService = $noticeOrNewsService;
    }

    /**
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->noticeOrNewsService->filterValidator($request)->validate();
        try {
            $response = $this->noticeOrNewsService->getNoticeOrNewsServiceList($filter, $this->startTime);
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
            $response = $this->noticeOrNewsService->getOneNoticeOrNewsService($id, $this->startTime);
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
        $validated = $this->noticeOrNewsService->validator($request)->validate();
        try {
            $noticeOrNews = $this->noticeOrNewsService->store($validated);
            $response = [
                'data' => $noticeOrNews,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Notice or News added successfully",
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
        $noticeOrNews = NoticeOrNews::findOrFail($id);
        $validated = $this->noticeOrNewsService->validator($request, $id)->validate();
        try {
            $noticeOrNews = $this->noticeOrNewsService->update($noticeOrNews, $validated);
            $response = [
                'data' => $noticeOrNews,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Notice or News updated successfully",
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
        $noticeOrNews = NoticeOrNews::findOrFail($id);
        try {
            $this->noticeOrNewsService->destroy($noticeOrNews);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Notice or News deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

}
