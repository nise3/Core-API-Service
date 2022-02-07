<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\LocDistrict;
use App\Models\User;
use App\Services\Common\CodeGenerateService;
use App\Services\UserRolePermissionManagementServices\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Khbd\LaravelWso2IdentityApiUser\IdpUser;
use RuntimeException;
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
        $validated['code'] = CodeGenerateService::getUserCode($validated['user_type']);
        $idpResponse = null;
        try {
            $idpUserPayLoad = [
                'first_name' => $validated['name'],
                'last_name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'],
                'password' => $validated['password'],
                'user_type' => $validated['user_type'],
                'account_disable' => $validated['row_status'] != BaseModel::ROW_STATUS_ACTIVE,
                'account_lock' => $validated['row_status'] != BaseModel::ROW_STATUS_ACTIVE
            ];
            $idpResponse = $this->userService->idpUserCreate($idpUserPayLoad);

            if (!empty($idpResponse['code']) && $idpResponse['code'] == ResponseAlias::HTTP_CONFLICT) {
                throw new RuntimeException('Idp user already exists', 409);
            }

            Log::info("mmm kkkk");
            Log::info(json_encode($idpResponse));

            if (!empty($idpResponse['data']['id'])) {
                $validated['idp_user_id'] = $idpResponse['data']['id'];
                $user = $this->userService->store($user, $validated);
                if (!$user) {
                    $idpUserId = $idpResponse['data']['id'];
                    $this->userService->idpUserDelete($idpUserId);
                    throw new RuntimeException('Saving user to DB is failed', 500);
                }
                $response = [
                    'data' => $user,
                    '_response_status' => [
                        "success" => true,
                        "code" => ResponseAlias::HTTP_CREATED,
                        "message" => "User added successfully",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];
            } else {
                throw new RuntimeException('User is not created', 500);
            }

        } catch (Throwable $e) {
            if (!empty($idpResponse['data']['id'])) {
                $idpUserId = $idpResponse['data']['id'];
                $this->userService->idpUserDelete($idpUserId);
            }
            throw $e;
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

        /** User cannot changes this attributes */
        $request->offsetSet('user_type', $user->user_type);
        $request->offsetSet('organization_id', $user->organization_id);
        $request->offsetSet('institute_id', $user->institute_id);
        $request->offsetSet('branch_id', $user->branch_id);
        $request->offsetSet('training_center_id', $user->training_center_id);
        $request->offsetSet('mobile', $user->mobile);
        $request->offsetSet('email', $user->email);
        $request->offsetSet('username', $user->username);

        $validated = $this->userService->validator($request, $id)->validate();

        DB::beginTransaction();
        try {
            $user = $this->userService->update($validated, $user);
            if ($user) {
                $idpUserPayload = [
                    'id' => $user->idp_user_id,
                    'username' => $user->username,
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'user_type' => $user->user_type,
                    'account_disable' => $user->row_status != BaseModel::ROW_STATUS_ACTIVE,
                    'account_lock' => $user->row_status != BaseModel::ROW_STATUS_ACTIVE
                ];
                $idpResponse = $this->userService->idpUserUpdate($idpUserPayload);
                throw_if(!empty($idpResponse['status']) && $idpResponse['status'] == false, "User not updated in Idp");

            }

            /** Remove cache data for this user */
            Cache::forget($user->idp_user_id);

            $response = [
                'data' => $user,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }


        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     * @throws Throwable
     */
    public function updateProfile(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->profileUpdatedValidator($request, $user)->validate();

        DB::beginTransaction();
        try {
            $user = $this->userService->update($validated, $user);
            if ($user) {
                $idpUserPayload = [
                    'id' => $user->idp_user_id,
                    'username' => $user->username,
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                ];
                $idpResponse = $this->userService->idpUserUpdate($idpUserPayload);
                throw_if(!empty($idpResponse['status']) && $idpResponse['status'] == false, "User not updated in Idp");
            }
            /** Remove cache data for this user */
            Cache::forget($user->idp_user_id);

            $response = [
                'data' => $user,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw  $e;
        }

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
        try {
            if ($user) {
                $idpResponse = $this->userService->idpUserDelete($user->idp_user_id);
                throw_if(!empty($idpResponse['status']) && $idpResponse['status'] == false, "User not deleted in Idp");
            }
            /** Remove cache data for this user */
            Cache::forget($user->idp_user_id);

            $this->userService->destroy($user);

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Delete user created from Organization ,institute and industryAssociation
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function userDestroy(Request $request): JsonResponse
    {
        $this->userService->userDelete($request);
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
     * Admin user create from different services when institute, organization, industry association create
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function adminUserCreate(Request $request): JsonResponse
    {
        $user = new User();
        $request['password'] = $request['password'] ?? BaseModel::ADMIN_CREATED_USER_DEFAULT_PASSWORD;
        $request['row_status'] = $request['row_status'] ?? BaseModel::ROW_STATUS_ACTIVE;

        $validated = $this->userService->adminUserCreateValidator($request)->validate();
        $validated['code'] = CodeGenerateService::getUserCode($validated['user_type']);
        Log::info(json_encode($validated));
        $idpResponse = null;

        DB::beginTransaction();
        try {
            $idpUserPayLoad = [
                'first_name' => $validated['name'],
                'last_name' => $validated['name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'],
                'username' => $validated['username'],
                'password' => $validated['password'],
                'user_type' => $validated['user_type'],
                'account_disable' => false,
                'account_lock' => false
            ];
            $idpResponse = $this->userService->idpUserCreate($idpUserPayLoad);

            if (!empty($idpResponse['code']) && $idpResponse['code'] == ResponseAlias::HTTP_CONFLICT) {
                throw new RuntimeException('Idp user already exists', ResponseAlias::HTTP_CONFLICT);
            }

            if (!empty($idpResponse['data']['id'])) {
                $validated['idp_user_id'] = $idpResponse['data']['id'];
                $user = $this->userService->createRegisterUser($user, $validated);

                if (!$user) {
                    $idpUserId = $idpResponse['data']['id'];
                    $this->userService->idpUserDelete($idpUserId);
                    throw new RuntimeException('Saving user to DB is failed', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
                }
//                $this->sendMessageToRegisteredUser($validated);
                $response = [
                    'data' => $user,
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
                throw new RuntimeException('User is not created', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            if (!empty($idpResponse['data']['id'])) {
                $idpUserId = $idpResponse['data']['id'];
                $this->userService->idpUserDelete($idpUserId);
            }
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
        $validatedData['code'] = CodeGenerateService::getUserCode($validatedData['user_type']);
        $idpResponse = null;
        try {
            /** @var  $idpUserPayLoad */
            $idpUserPayLoad = [
                'first_name' => $validatedData['name'],
                'last_name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'mobile' => $validatedData['mobile'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'user_type' => $validatedData['user_type'],
                'account_disable' => true,
                'account_lock' => true
            ];

            Log::info("<===================================================================>");
            Log::info("openUserPayload: " . json_encode($idpUserPayLoad));
            Log::info("<===================================================================>");

            $idpResponse = $this->userService->idpUserCreate($idpUserPayLoad);

            if (!empty($idpResponse['code']) && $idpResponse['code'] == ResponseAlias::HTTP_CONFLICT) {
                throw new RuntimeException('Idp user already exists', ResponseAlias::HTTP_CONFLICT);
            }
            if (!empty($idpResponse['data']['id'])) {
                $validatedData['idp_user_id'] = $idpResponse['data']['id'];
                $validatedData['row_status'] = BaseModel::ROW_STATUS_PENDING;

                $user = $this->userService->store($user, $validatedData);

                if (!$user) {
                    $idpUserId = $idpResponse['data']['id'];
                    $this->userService->idpUserDelete($idpUserId);
                    throw new RuntimeException('Saving user to DB is failed', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
                }

                $response = [
                    'data' => $user,
                    '_response_status' => [
                        "success" => true,
                        "code" => ResponseAlias::HTTP_CREATED,
                        "message" => "User added successfully",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];

            } else {
                throw new RuntimeException('User is not created', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Throwable $e) {
            if (!empty($idpResponse['data']['id'])) {
                $idpUserId = $idpResponse['data']['id'];
                $this->userService->idpUserDelete($idpUserId);
            }
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    private function sendMessageToRegisteredUser(array $data): bool
    {
        $message = 'Welcome to NISE-3. Your username is ' . $data['username'] . " and password is " . $data['password'];
        return sms()->send($data['username'], $message)->is_successful();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception|Throwable
     */
    public function userApproval(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $users = $this->userService->userApproval($request);

            if ($users) {
                foreach ($users as $user) {
                    $idpUserPayload = array(
                        'id' => $user->idp_user_id,
                        'username' => $user->username,
                        'account_disable' => false,
                        'account_lock' => false
                    );
                    $idpResponse = $this->userService->idpUserUpdate($idpUserPayload);
                    throw_if(!empty($idpResponse['status']) && $idpResponse['status'] == false, "User not updated in Idp");
                }
            }
            $response = [
                'data' => $users ?? null,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User is approved successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception|Throwable
     */
    public function userRejection(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $users = $this->userService->userRejection($request);

            if ($users) {
                foreach ($users as $user) {
                    $idpUserPayload = array(
                        'id' => $user->idp_user_id,
                        'username' => $user->username,
                        'account_disable' => true
                    );
                    $this->userService->idpUserUpdate($idpUserPayload);
                    throw_if(!empty($idpResponse['status']) && $idpResponse['status'] == false, "User not updated in Idp");
                }

            }
            $response = [
                'data' => $users ?? null,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "User is rejected successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

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
