<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use App\Services\UserRolePermissionManagementServices\PermissionGroupService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class PermissionGroupController extends Controller
{
    public PermissionGroupService $permissionGroupService;
    public Carbon $startTime;

    /**
     * PermissionGroupController constructor.
     * @param PermissionGroupService $permissionGroupService
     * @param Carbon $startTime
     */
    public function __construct(PermissionGroupService $permissionGroupService, Carbon $startTime)
    {
        $this->permissionGroupService = $permissionGroupService;
        $this->startTime = $startTime;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->permissionGroupService->filterValidator($request)->validate();

        $response = $this->permissionGroupService->getAllPermissionGroups($filter, $this->startTime);
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function read(Request $request,int $id): JsonResponse
    {
        $response = $this->permissionGroupService->getOnePermissionGroup($request,$id, $this->startTime);
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->permissionGroupService->validator($request)->validate();

        $permissionGroup = new PermissionGroup();
        $permissionGroup = $this->permissionGroupService->store($validated, $permissionGroup);
        $response = [
            'data' => $permissionGroup,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "PermissionGroup added successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        /** @var PermissionGroup $permissionGroup */
        $permissionGroup = PermissionGroup::findOrFail($id);
        $validated = $this->permissionGroupService->validator($request, $id)->validate();

        $permissionGroup = $this->permissionGroupService->update($validated, $permissionGroup);
        $response = [
            'data' => $permissionGroup,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "PermissionGroup updated successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        /** @var PermissionGroup $permissionGroup */
        $permissionGroup = PermissionGroup::findOrFail($id);
        $this->permissionGroupService->destroy($permissionGroup);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "PermissionGroup deleted successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function assignPermissionToPermissionGroup(Request $request, int $id): JsonResponse
    {
        /** @var PermissionGroup $permissionGroup */
        $permissionGroup = PermissionGroup::findOrFail($id);
        $validated = $this->permissionGroupService->permissionValidation($request)->validated();
        $permissionGroup=$this->permissionGroupService->assignPermission($permissionGroup, $validated['permissions']);
        $response = [
            'data'=>$permissionGroup->permissions()->get(),
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Permission(s) assigned into Permission Group successfully done",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
