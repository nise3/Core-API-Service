<?php

namespace App\Http\Controllers;

use App\Models\PermissionSubGroup;
use App\Services\UserRolePermissionManagementServices\PermissionSubGroupService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
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
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->permissionSubGroupService->filterValidator($request)->validate();

        $response = $this->permissionSubGroupService->getAllPermissionSubGroups($filter, $this->startTime);
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function read(Request $request, int $id): JsonResponse
    {
        $response = $this->permissionSubGroupService->getOnePermissionSubGroup($id, $this->startTime);
        return Response::json($response);
    }

    /**
     * @param string $title
     * @return JsonResponse
     */
    public function getByTitle(string $title): JsonResponse
    {
        $title =urldecode($title);
        Log::info($title);
        $response = $this->permissionSubGroupService->getOnePermissionSubGroupByTitle($title, $this->startTime);
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->permissionSubGroupService->validator($request)->validate();
        $permissionSubGroup = new PermissionSubGroup();
        $permissionSubGroup = $this->permissionSubGroupService->store($validated, $permissionSubGroup);
        $response = [
            'data' => $permissionSubGroup,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Permission Sub Group added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $permissionSubGroup = PermissionSubGroup::findOrFail($id);
        $validated = $this->permissionSubGroupService->validator($request, $id)->validate();
        $permissionSubGroup = $this->permissionSubGroupService->update($validated, $permissionSubGroup);
        $response = [
            'data' => $permissionSubGroup,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Permission Sub Group updated successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $permissionSubGroup = PermissionSubGroup::findOrFail($id);
        $this->permissionSubGroupService->destroy($permissionSubGroup);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Permission Sub Group deleted successfully",
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
    public function assignPermissionToPermissionSubGroup(Request $request, int $id):JsonResponse
    {
        $permissionSubGroup = PermissionSubGroup::findOrFail($id);
        $validated = $this->permissionSubGroupService->permissionValidation($request)->validated();
        $permissionSubGroup = $this->permissionSubGroupService->assignPermission($permissionSubGroup, $validated['permissions']);
        Cache::flush(); // invalidate all user cache data when permission sub group permission assign
        $response = [
            'data' => $permissionSubGroup->permissions()->get(),
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Permission added to PermissionSubGroup successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
