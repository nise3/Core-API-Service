<?php

namespace App\Http\Controllers;

use App\Models\LocUpazila;
use App\Services\Sevices\LocService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class LocUpazilaController extends Controller
{
    public $locService;

    /**
     * LocDivisionController constructor.
     * @param $locService
     */
    public function __construct(LocUpazila $locUpazila)
    {
        $this->locService = new LocService($locUpazila);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [];
        $startTime = Carbon::now();
        $response_code = 200;
        try {
            $relation=['district','division'];
            $response = $this->locService->viewAll($relation);
            $response=(object)$response->toArray();

            $response = [
                "data" => $response->data,
                "_response_status" => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ],
                "_links" => $response->links,
                "_page" => [
                    "size" => $response->per_page,
                    "total_element" => $response->total,
                    "total_page" => $response->last_page,
                    "current_page" => $response->current_page
                ],
                "_order" => 'asc'
            ];
        } catch (\Exception $exp) {

            Log::debug(json_encode([
                'exp_error_message' => $exp->getMessage(),
            ]));

            /*response message*/
            $response_code = 500;
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Something is wrong.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        }

        return Response::json($response, $response_code);
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
        $response_code = 201;
        $startTime = Carbon::now();

        if($request->method()=="POST"){
            try
            {
                $this->locService->store($request);

                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => $response_code,
                        "message" => "Job finished successfully.",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];

            }catch (\Exception $exp){
                Log::debug(json_encode([
                    'exp_error_message' => $exp->getMessage(),
                ]));
                /*response message*/
                $response_code = 500;
                $response = [
                    '_response_status' => [
                        "success" => true,
                        "code" => $response_code,
                        "message" => "Something is wrong.",
                        "started" => $startTime,
                        "finished" => Carbon::now(),
                    ]
                ];
            }
        }
        return Response::json($response, $response_code);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\LocDivision $locDivision
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = [];
        $response_code = 200;
        $startTime = Carbon::now();

        try {
            $relation=['district','division'];
            $response = $this->locService->view($id,$relation);
            $response = [
                "data" => $response,
                "_response_status" => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ],
                "_links" => [

                ]
            ];
        } catch (\Exception $exp) {
            Log::debug(json_encode([
                'exp_error_message' => $exp->getMessage(),
            ]));

            /*response message*/
            $response_code = 500;
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Something is wrong.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        }
        return Response::json($response, $response_code);
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
        $response_code = 201;
        $startTime = Carbon::now();

        try {
            $this->locService->update($request,$id);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $response_code,
                    "message" =>  "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        }catch (\Exception $exp){
            Log::debug(json_encode([
                'exp_error_message' => $exp->getMessage(),
            ]));

            /*response message*/
            $response_code = 500;
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Something is wrong.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        }
        return Response::json($response, $response_code);
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
        $response_code = 201;
        $startTime = Carbon::now();
        try {
            $this->locService->destroy($id);
            /*response message*/
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Job finished successfully.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        }catch (\Exception $exp){
            Log::debug(json_encode([
                'exp_error_message' => $exp->getMessage(),
            ]));
            /*response message*/
            $response_code = 500;
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => $response_code,
                    "message" => "Something is wrong.",
                    "started" => $startTime,
                    "finished" => Carbon::now(),
                ]
            ];
        }
        return Response::json($response, $response_code);
    }
}
