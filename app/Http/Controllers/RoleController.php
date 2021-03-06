<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserRolePermissionManagementServices\RoleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    public RoleService $roleService;
    public Carbon $startTime;

    /**
     * RoleController constructor.
     * @param RoleService $roleService
     * @param Carbon $startTime
     */
    public function __construct(RoleService $roleService, Carbon $startTime)
    {
        $this->startTime = $startTime;
        $this->roleService = $roleService;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->roleService->filterValidator($request)->validate();

        $response = $this->roleService->getAllRoles($filter, $this->startTime);
        return Response::json($response);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getRolesForFourIR(Request $request): JsonResponse
    {
        $filter = $this->roleService->filterValidator($request)->validate();
        $response = $this->roleService->getAllRoleForFourIR($filter, $this->startTime);
        return Response::json($response, $response['_response_status']['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $response = $this->roleService->getOneRole($id, $this->startTime);
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->roleService->validator($request)->validate();
        /** @var User $authUser */
        $authUser = Auth::user();
        $validated['permission_group_id'] = $authUser->role->permission_group_id;
        $validated['permission_sub_group_id'] = $authUser->role->permission_sub_group_id;
        $role = $this->roleService->store($validated);
        $response = [
            'data' => $role,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Role added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $validated = $this->roleService->validator($request, $id)->validate();
        $role = $this->roleService->update($role, $validated);
        $response = [
            'data' => $role,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Role updated successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy($id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $this->roleService->destroy($role);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Role deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function assignPermissionToRole(Request $request, $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $validated = $this->roleService->permissionValidation($request)->validated();
        $role = $this->roleService->assignPermission($role, $validated['permissions']);

        Cache::flush(); // invalidate all cache data when role permission assign

        $response = [
            'data' => $role,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Permission assigned into Role successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
