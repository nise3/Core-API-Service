<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\CustomExceptionHandler;
use App\Models\PermissionSubGroup;
use App\Services\UserRolePermissionManagementServices\PermissionSubGroupService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->permissionSubGroupService->filterValidator($request)->validate();

        try {
            $response = $this->permissionSubGroupService->getAllPermissionSubGroups($filter, $this->startTime);
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function read(Request $request, int $id): JsonResponse
    {
        try {
            $response = $this->permissionSubGroupService->getOnePermissionSubGroup($id, $this->startTime);
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response);
    }

    /**
     * @param Request $request
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->permissionSubGroupService->validator($request)->validate();
        try {
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
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $permissionSubGroup = PermissionSubGroup::findOrFail($id);
        $validated = $this->permissionSubGroupService->validator($request, $id)->validate();
        try {
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
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $permissionSubGroup = PermissionSubGroup::findOrFail($id);
        try {
            $this->permissionSubGroupService->destroy($permissionSubGroup);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Permission Sub Group deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function assignPermissionToPermissionSubGroup(Request $request, int $id): JsonResponse
    {
        $permissionSubGroup = PermissionSubGroup::findOrFail($id);
        $validated = $this->permissionSubGroupService->permissionValidation($request)->validated();
        try {
            $permissionSubGroup = $this->permissionSubGroupService->assignPermission($permissionSubGroup, $validated['permissions']);
            $response = [
                'data' => $permissionSubGroup,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Permission added to PermissionSubGroup successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
