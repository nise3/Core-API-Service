<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\User;
use App\Services\UserRolePermissionManagementServices\UserService;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    public UserService $userService;
    /**
     * @var Carbon
     */
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
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->userService->filterValidator($request)->validate();

        $response = $this->userService->getAllUsers($filter, $this->startTime);
        return Response::json($response);
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
        $response = $this->userService->getOneUser($id, $this->startTime);
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
        $user = new User();
        $request['username'] = strtolower(str_replace(" ", "_", $request['username']));
        $validated = $this->userService->validator($request)->validate();

        $idpUserPayLoad = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => $validated['password'],
            'user_type' => $validated['user_type'],
            'status' => $validated['row_status']
        ];

        $httpClient = $this->userService->idpUserCreate($idpUserPayLoad);
        if ($httpClient->json('id')) {
            $validated['idp_user_id'] = $httpClient->json('id');
            $user = $this->userService->store($user, $validated);
            $response = [
                'data' => $user ?? [],
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "User added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
            DB::commit();
        } else {
            DB::rollBack();
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                    "message" => "User is not created",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        }
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
        $user = User::findOrFail($id);
        $validated = $this->userService->validator($request, $id)->validate();
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

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateProfile(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->profileUpdatedValidator($request, $user)->validate();
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
        $user = User::findOrFail($id);
        $this->userService->destroy($user);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "User deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws Throwable
     * @throws RequestException
     */
    public function getUserPermissionList(Request $request, string $id): JsonResponse
    {
        $user = $this->userService->getUserPermissionWithMenuItems($id);
        $response = [
            'data' => $user ?? [],
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "User Permission List",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * Internal service Api call for Auth User Information
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function getAuthUserInfoByIdpId(Request $request): JsonResponse
    {
        $authUserInfo = $this->userService->getAuthPermission($request->idp_user_id ?? null);
        $response = [
            'data' => $authUserInfo,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Auth User information",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Admin user create from different services
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function adminUserCreate(Request $request): JsonResponse
    {
        $user = new User();
        $request['password'] = $request['password'] ?? BaseModel::ADMIN_CREATED_USER_DEFAULT_PASSWORD;
        $validated = $this->userService->adminUserCreateValidator($request)->validate();
        Log::info(json_encode($validated));
        DB::beginTransaction();
        try {
            $idpUserPayLoad = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'password' => $validated['password'],
                'user_type' => $validated['user_type'],
                'status' => BaseModel::ROW_STATUS_ACTIVE
            ];
            $httpClient = $this->userService->idpUserCreate($idpUserPayLoad);

            if ($httpClient->json('id')) {
                $validated['idp_user_id'] = $httpClient->json('id');
                $user = $this->userService->createRegisterUser($user, $validated);
//                $this->sendMessageToRegisteredUser($validated);
                $response = [
                    'data' => $user ?: [],
                    '_response_status' => [
                        "success" => true,
                        "code" => ResponseAlias::HTTP_CREATED,
                        "message" => "User added successfully",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];
                DB::commit();
            } else {
                DB::rollBack();
                $response = [
                    '_response_status' => [
                        "success" => false,
                        "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => "User is not created",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];
            }
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * User open registration from different services
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function userOpenRegistration(Request $request): JsonResponse
    {
        $user = new User();
        $validatedData = $this->userService->userOpenRegistrationValidator($request)->validate();
        DB::beginTransaction();
        try {
            /** @var  $idpUserPayLoad */
            $idpUserPayLoad = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'user_type' => $validatedData['user_type'],
                'status' => BaseModel::ROW_STATUS_PENDING
            ];

            $httpClient = $this->userService->idpUserCreate($idpUserPayLoad);
            if ($httpClient->json('id')) {
                $validatedData['idp_user_id'] = $httpClient->json('id');;
                $validatedData['row_status'] = BaseModel::ROW_STATUS_PENDING;

                $user = $this->userService->store($user, $validatedData);

                $response = [
                    'data' => $user ?: [],
                    '_response_status' => [
                        "success" => true,
                        "code" => ResponseAlias::HTTP_CREATED,
                        "message" => "User added successfully",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];
                DB::commit();
            } else {
                DB::rollBack();
                $response = [
                    '_response_status' => [
                        "success" => false,
                        "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => "User is not created",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];
            }
            return Response::json($response, ResponseAlias::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }

    private function sendMessageToRegisteredUser(array $data): bool
    {
        $message = 'Welcome to NISE-3. Your username is ' . $data['username'] . " and password is " . $data['password'];
        return sms()->send($data['username'], $message)->is_successful();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userApproval(Request $request): JsonResponse
    {
        $user = $this->userService->userApproval($request);
        $response = [
            'data' => $user ?: null,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "User is approved successfully",
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
    public function assignPermissionToUser(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->permissionValidation($request)->validated();
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
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function assignRoleToUser(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->roleIdValidation($request)->validated();
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
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
