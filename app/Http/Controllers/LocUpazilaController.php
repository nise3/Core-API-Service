<?php

namespace App\Http\Controllers;

use App\Services\LocationManagementServices\locUpazilaService;
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

class LocUpazilaController extends Controller
{
    /**
     * @var locUpazilaService
     */
    public LocUpazilaService $locUpazilaService;


    /**
     * LocUpazilaController constructor.
     * @param LocUpazilaService $locUpazilaService
     */
    public function __construct(LocUpazilaService $locUpazilaService)
    {
        $this->locUpazilaService = $locUpazilaService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewAll(Request $request)
    {
        $response = [];
        $startTime = Carbon::now();
        try {
            $response = $this->locUpazilaService->getAllUpazilas($request);
        } catch (HttpResponseException | FatalThrowableError | Exception $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Internal Server Error!",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (MethodNotAllowedHttpException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                    "message" => "Method Not Allowed",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        } catch (NotFoundHttpException | ModelNotFoundException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_NOT_FOUND,
                    "message" => "404 Not Found",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_FORBIDDEN,
                    "message" => "You are not authorised to perform this action",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (UnableToExecuteRequestException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $e->getCode(),
                    "message" => "Unable to execute the request",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, $e->getCode());
        } catch (ValidationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            if ($e->getResponse()) {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_BAD_REQUEST,
                        "message" => "Bad Request",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => $e->validator->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        return Response::json($response);
    }


    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function view(Request $request, $id)
    {
        $response = [];
        $startTime = Carbon::now();

        try {
            $response = $this->locUpazilaService->getOneUpazila($id);
        } catch (HttpResponseException | FatalThrowableError | Exception $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Internal Server Error!",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (MethodNotAllowedHttpException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                    "message" => "Method Not Allowed",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        } catch (NotFoundHttpException | ModelNotFoundException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_NOT_FOUND,
                    "message" => "404 Not Found",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_FORBIDDEN,
                    "message" => "You are not authorised to perform this action",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (UnableToExecuteRequestException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $e->getCode(),
                    "message" => "Unable to execute the request",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, $e->getCode());
        } catch (ValidationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            if ($e->getResponse()) {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_BAD_REQUEST,
                        "message" => "Bad Request",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => 422,
                        "message" => $e->validator->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, 422);
            }

        }
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = [];
        $startTime = Carbon::now();

        try {
            $validation = Validator::make($request->all(), [
                'loc_district_id'=>'required|numeric',
                'loc_division_id'=>'required|numeric',
                'title_en' => 'required|min:2',
                'title_bn' => 'required|min:2',
            ]);
            if ($validation->fails()) {
                $response = [
                    "_response_status" => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => $validation->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $this->locUpazilaService->store($request);

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_CREATED,
                    "message" => "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];

        } catch (HttpResponseException | FatalThrowableError | Exception $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Internal Server Error!",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (MethodNotAllowedHttpException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                    "message" => "Method Not Allowed",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        } catch (NotFoundHttpException | ModelNotFoundException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_NOT_FOUND,
                    "message" => "404 Not Found",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_FORBIDDEN,
                    "message" => "You are not authorised to perform this action",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (UnableToExecuteRequestException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $e->getCode(),
                    "message" => "Unable to execute the request",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, $e->getCode());
        } catch (ValidationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            if ($e->getResponse()) {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_BAD_REQUEST,
                        "message" => "Bad Request",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => 422,
                        "message" => $e->validator->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, 422);
            }

        }
        return Response::json($response, JsonResponse::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LocDivision $locDivision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = [];
        $startTime = Carbon::now();

        try {

            $validation = Validator::make($request->all(), [
                'loc_district_id'=>'required|numeric',
                'loc_division_id'=>'required|numeric',
                'title_en' => 'required|min:2',
                'title_bn' => 'required|min:2',
            ]);
            if ($validation->fails()) {
                $response = [
                    "_response_status" => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => $validation->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $this->locUpazilaService->update($request, $id);

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];

        } catch (HttpResponseException | FatalThrowableError | Exception $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Internal Server Error!",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (MethodNotAllowedHttpException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                    "message" => "Method Not Allowed",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        } catch (NotFoundHttpException | ModelNotFoundException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_NOT_FOUND,
                    "message" => "404 Not Found",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_FORBIDDEN,
                    "message" => "You are not authorised to perform this action",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (UnableToExecuteRequestException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $e->getCode(),
                    "message" => "Unable to execute the request",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, $e->getCode());
        } catch (ValidationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            if ($e->getResponse()) {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_BAD_REQUEST,
                        "message" => "Bad Request",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => 422,
                        "message" => $e->validator->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, 422);
            }

        }
        return Response::json($response, JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\LocDivision $locDivision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [];
        $startTime = Carbon::now();
        try {
            $this->locUpazilaService->destroy($id);
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        } catch (HttpResponseException | FatalThrowableError | Exception $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Internal Server Error!",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (MethodNotAllowedHttpException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                    "message" => "Method Not Allowed",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        } catch (NotFoundHttpException | ModelNotFoundException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_NOT_FOUND,
                    "message" => "404 Not Found",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_FORBIDDEN,
                    "message" => "You are not authorised to perform this action",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (UnableToExecuteRequestException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $e->getCode(),
                    "message" => "Unable to execute the request",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, $e->getCode());
        } catch (ValidationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            if ($e->getResponse()) {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_BAD_REQUEST,
                        "message" => "Bad Request",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => 422,
                        "message" => $e->validator->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, 422);
            }

        }
        return Response::json($response, JsonResponse::HTTP_OK);
    }


    /**
     * @param Request $request
     * @param $district_id
     * @return JsonResponse
     */
    public function getUpazilaByDistrict(Request $request, $district_id){
        $response = [];
        $startTime = Carbon::now();
        try {
            $response=$this->locUpazilaService->getUpazilaByDistrictId($request,$district_id);
        } catch (HttpResponseException | FatalThrowableError | Exception $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    "message" => "Internal Server Error!",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (MethodNotAllowedHttpException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                    "message" => "Method Not Allowed",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        } catch (NotFoundHttpException | ModelNotFoundException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_NOT_FOUND,
                    "message" => "404 Not Found",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_FORBIDDEN,
                    "message" => "You are not authorised to perform this action",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_NOT_FOUND);
        } catch (UnableToExecuteRequestException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $e->getCode(),
                    "message" => "Unable to execute the request",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
            return Response::json($response, $e->getCode());
        } catch (ValidationException $e) {
            Log::debug($e->getMessage());
            Log::debug($e->getTraceAsString());
            /*response message*/
            if ($e->getResponse()) {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => JsonResponse::HTTP_BAD_REQUEST,
                        "message" => "Bad Request",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => 422,
                        "message" => $e->validator->errors(),
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
                return Response::json($response, 422);
            }

        }
        return Response::json($response, JsonResponse::HTTP_OK);
    }
}
