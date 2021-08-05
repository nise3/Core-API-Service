<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\CustomExceptionHandler;
use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use App\Services\UserRolePermissionManagementServices\PermissionGroupService;
use App\Services\UserRolePermissionManagementServices\PermissionSubGroupService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Throwable;

class PermissionSubGroupController extends Controller
{
    public PermissionSubGroupService $permissionSubGroupService;
    public Carbon $startTime;


    public function __construct(PermissionSubGroupService $permissionSubGroupService, Carbon $startTime)
    {
        $this->permissionSubGroupService = $permissionSubGroupService;
        $this->startTime = $startTime;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
        try {
            $response = $this->permissionSubGroupService->getAllPermissionSubGroups($request);
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
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function read(Request $request, int $id): JsonResponse
    {
        try {
            $response = $this->permissionSubGroupService->getOnePermissionSubGroup($request, $id);
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

        return Response::json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {

        $validated = $this->permissionSubGroupService->validator($request)->validate();

        try {
            $permission_sub_group = new PermissionSubGroup();
            //TODO: Only Validated data will stored.
            $permission_sub_group = $this->permissionSubGroupService->store($validated, $permission_sub_group);
            //TODO: never response in try block if not necessary.
            $response = [
                'data' => $permission_sub_group,
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
            return Response::json($response, $response['_response_status']['code']);
        }

        return Response::json($response, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $permission_sub_group = PermissionSubGroup::findOrFail($id);
        $validated = $this->permissionSubGroupService->validator($request, $id)->validate();

        try {
            $permission_sub_group = $this->permissionSubGroupService->update($validated, $permission_sub_group);
            $response = [
                'data' => $permission_sub_group,
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

        return Response::json($response, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $permission_sub_group = PermissionSubGroup::findOrFail($id);
        try {
            $permission_sub_group = $this->permissionSubGroupService->destroy($permission_sub_group);
            $response = [
                'data' => $permission_sub_group,
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

    public function assignPermissionToPermissionSubGroup(Request $request, int $id)
    {
        $permission_sub_group = PermissionSubGroup::findOrFail($id);
        $validated = $this->permissionSubGroupService->validator($request)->validated();

        try {
            $permission_sub_group = $this->permissionSubGroupService->assignPermission($permission_sub_group, $validated['permissions']);
            $response = [
                'data' => $permission_sub_group,
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
