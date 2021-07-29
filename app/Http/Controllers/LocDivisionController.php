<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\CustomExceptionHandler;
use App\Models\LocDivision;
use App\Services\LocationManagementServices\LocDivisionService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class LocDivisionController extends Controller
{
    /**
     * @var LocDivisionService
     */
    public LocDivisionService $locDivisionService;

    /**
     * @var Carbon
     */
    public Carbon $startTime;


    /**
     * LocDivisionController constructor.
     * @param LocDivisionService $locDivisionService
     */
    public function __construct(LocDivisionService $locDivisionService,Carbon $startTime)
    {
        $this->locDivisionService = $locDivisionService;
        $this->startTime=$startTime;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
        try {
            $response = $this->locDivisionService->getAllDivisions($request);
        } catch (Throwable $e) {
            $handler = new CustomExceptionHandler($e);
            $response = [
                '_response_status' => array_merge([
                    "success" => false,
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ], $handler->convertExceptionToArray())
            ];
            if ($response['_response_status']['code'] == JsonResponse::HTTP_UNPROCESSABLE_ENTITY) {
                $response['_response_status']['message'] = $this->locDivisionService->validator($request)->errors();
            }
            return Response::json($response, $response['_response_status']['code']);
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request, $id):JsonResponse
    {
        try {
            $response = $this->locDivisionService->getOneDivision($id);
        } catch (Throwable $e) {
            $handler = new CustomExceptionHandler($e);
            $response = [
                '_response_status' => array_merge([
                    "success" => false,
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ], $handler->convertExceptionToArray())
            ];
            if ($response['_response_status']['code'] == JsonResponse::HTTP_UNPROCESSABLE_ENTITY) {
                $response['_response_status']['message'] = $this->locDivisionService->validator($request)->errors();
            }
            return Response::json($response, $response['_response_status']['code']);
        }

        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):JsonResponse
    {
        try {
            $validated = $this->locDivisionService->validator($request)->validate();
            $this->locDivisionService->store($validated);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_CREATED,
                    "message" => "Job finished successfully.",
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ]
            ];

        } catch (Throwable $e) {
            $handler = new CustomExceptionHandler($e);
            $response = [
                '_response_status' => array_merge([
                    "success" => false,
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ], $handler->convertExceptionToArray())
            ];
            if ($response['_response_status']['code'] == JsonResponse::HTTP_UNPROCESSABLE_ENTITY) {
                $response['_response_status']['message'] = $this->locDivisionService->validator($request)->errors();
            }
            return Response::json($response, $response['_response_status']['code']);
        }
        return Response::json($response, JsonResponse::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id):JsonResponse
    {
        $locDivision=LocDivision::findOrFail($id);
        try {
            $validated = $this->locDivisionService->validator($request)->validate();

            $this->locDivisionService->update($validated, $locDivision);

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => "Job finished successfully.",
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ]
            ];

        } catch (Throwable $e) {
            $handler = new CustomExceptionHandler($e);
            $response = [
                '_response_status' => array_merge([
                    "success" => false,
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ], $handler->convertExceptionToArray())
            ];
            if ($response['_response_status']['code'] == JsonResponse::HTTP_UNPROCESSABLE_ENTITY) {
                $response['_response_status']['message'] = $this->locDivisionService->validator($request)->errors();
            }

            return Response::json($response, $response['_response_status']['code']);
        }
        return Response::json($response, JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $locDivision=LocDivision::findOrFail($id);
        try {
            $this->locDivisionService->destroy($locDivision);
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => "Job finished successfully.",
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        } catch (Throwable $e) {
            $handler = new CustomExceptionHandler($e);
            $response = [
                '_response_status' => array_merge([
                    "success" => false,
                    "started" => $this->startTime,
                    "finished" => Carbon::now(),
                ], $handler->convertExceptionToArray())
            ];
            return Response::json($response, $response['_response_status']['code']);

        }
        return Response::json($response, JsonResponse::HTTP_OK);
    }
}
