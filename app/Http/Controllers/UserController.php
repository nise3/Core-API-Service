<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserRolePermissionManagementServices\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class UserController extends Controller
{
    public UserService $userService;
    private Carbon $startTime;

    /**
     * RoleController constructor.
     * @param UserService $userService
     * @param Carbon $startTime
     */
    public function __construct(UserService $userService, Carbon $startTime)
    {
        $this->startTime = $startTime;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Exception|JsonResponse|Throwable
     */
    public function getList(Request $request):JsonResponse
    {
        try {
            $response = $this->userService->getAllUsers($request, $this->startTime);
        } catch (\Throwable $e) {
          return $e;
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function read(Request $request, int $id):JsonResponse
    {
        try {
            $response = $this->userService->getOneUser($id, $this->startTime);
        } catch (\Throwable $e) {
           return $e;
        }
        return Response::json($response);
    }


    /**
     * @param Request $request
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function store(Request $request):JsonResponse
    {
        $user = new User();
        $validated = $this->userService->validator($request)->validate();
        try {
            $validated['password'] = Hash::make('password');
            $user = $this->userService->store($user, $validated);
            $response = [
                'data' => $user,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "User added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id):JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->validator($request, $id)->validate();
        try {
            $user = $this->userService->update($validated, $user);
            $response = [
                'data' => $user,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (\Throwable $e) {
          return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function destroy(int $id):JsonResponse
    {
        $user = User::findOrFail($id);
        try {
            $this->userService->destroy($user);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (\Throwable $e) {
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
    public function assignPermissionToUser(Request $request, int $id):JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->permissionValidation($request)->validated();
        try {
            $user = $this->userService->assignPermission($user, $validated['permissions']);
            $response = [
                'data' => $user,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Permission assigned into User successfully",
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
    public function assignRoleToUser(Request $request, int $id):JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->roleIdValidation($request)->validated();
        try {
            $user = $this->userService->setRole($user, $validated['role_id']);
            $response = [
                'data' => $user,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Role assigned into User successfully.",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
