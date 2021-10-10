<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Services\ContentManagementServices\SliderService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;
use Exception;

class SliderController extends Controller
{
    public SliderService $sliderService;
    private Carbon $startTime;


    public function __construct(SliderService $sliderService)
    {
        $this->startTime = Carbon::now();
        $this->sliderService = $sliderService;
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
        $filter = $this->sliderService->filterValidator($request)->validate();

        try {
            $response = $this->sliderService->getAllSliders($filter, $this->startTime);
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
            $response = $this->sliderService->getOneSlider($id, $this->startTime);
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
        $validated = $this->sliderService->validator($request)->validate();
        try {
            $slider = $this->sliderService->store($validated);
            $response = [
                'data' => $slider,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Slider added successfully",
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
        $slider = Slider::findOrFail($id);
        $validated = $this->sliderService->validator($request, $id)->validate();
        try {
            $slider = $this->sliderService->update($slider, $validated);
            $response = [
                'data' => $slider,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Slider updated successfully",
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
        $slider = Slider::findOrFail($id);
        try {
            $this->sliderService->destroy($slider);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Slider deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
