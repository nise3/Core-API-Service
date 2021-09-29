<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\User;
use App\Services\UserRolePermissionManagementServices\UserService;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use FastRoute\RouteParser\Std;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Psy\Util\Str;
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
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->userService->filterValidator($request)->validate();

        try {
            $response = $this->userService->getAllUsers($filter, $this->startTime);
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
    public function read(Request $request, int $id): JsonResponse
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
     * @return array|\Exception|Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $user = new User();
        $request['username'] = strtolower(str_replace(" ", "_", $request['username']));
        $validated = $this->userService->validator($request)->validate();
        try {
            $httpClient = $this->userService->idpUserCreate($validated);
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
    public function update(Request $request, int $id): JsonResponse
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

    public function updateProfile(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $validated = $this->userService->profileUpdatedvalidator($request, $user)->validate();
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
    public function destroy(int $id): JsonResponse
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
     * @param string $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function getUserPermissionList(Request $request, string $id)
    {
        try {
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
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * Internal service Api call for Auth User Information
     * @param Request $request
     * @return array|\Exception|JsonResponse|Throwable
     */
    public function getAuthUserInfoByIdpId(Request $request):JsonResponse
    {
        try {
            $authUserInfo=$this->userService->getAuthPermission($request->idp_user_id ?? null);
            $response = [
                'data' => $authUserInfo,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Auth User information",
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
     * @return \Exception|JsonResponse|Throwable
     */
    public function organizationOrInstituteUserCreate(Request $request)
    {
        $user = new User();
        $request['password'] = $request['password'] ?? '123456';
        $validated = $this->userService->organizationOrInstituteUserValidator($request)->validate();
        DB::beginTransaction();
        try {

            $idpUserPayLoad = [
                'name' => $validated['name_en'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'password' => $validated['password']
            ];

            $httpClient = $this->userService->idpUserCreate($idpUserPayLoad);

            if ($httpClient->json('id')) {
                $validated['idp_user_id'] = $httpClient->json('id');
                $user = $this->userService->createRegisterUser($user, $validated);
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
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function registerUser(Request $request): JsonResponse
    {
        $user = new User();
        $validatedData = $this->userService->registerUserValidator($request)->validate();
        DB::beginTransaction();
        try {
            /** @var  $idpUserPayLoad */
            $idpUserPayLoad = [
                'name' => $validatedData['name_en'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password']
            ];

            $httpClient = Uuid::uuid();  //$this->userService->idpUserCreate($idpUserPayLoad);
            if ($httpClient) {
                $validatedData['idp_user_id'] = $httpClient;
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
        } catch (Throwable $e) {
            DB::rollBack();
            return $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return \Exception|JsonResponse|Throwable
     */
    public function userApproval(int $id): JsonResponse
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($user->row_status != 1) {
                /**Idp User Payload*/
                $idpUserPayLoad = [
                    'name' => $user->name_en,
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => "123456",
                ];
                $httpClient = Uuid::uuid();
                if ($httpClient) {
                    $data['row_status'] = BaseModel::ROW_STATUS_ACTIVE;
                    $user = $this->userService->update($data, $user);
                    $response = [
                        'data' => $user ?: [],
                        '_response_status' => [
                            "success" => true,
                            "code" => ResponseAlias::HTTP_OK,
                            "message" => "User is approved successfully",
                            "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                        ]
                    ];
                    DB::commit();
                } else {
                    DB::rollBack();
                    $response = [
                        'data' => $user ?: [],
                        '_response_status' => [
                            "success" => false,
                            "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                            "message" => "User is not created",
                            "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                        ]
                    ];
                }
            } else {
                $response = [
                    '_response_status' => [
                        "success" => false,
                        "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => "User has already approved!",
                        "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                    ]
                ];
            }

        } catch (Throwable $e) {
            DB::rollBack();
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
    public function assignPermissionToUser(Request $request, int $id): JsonResponse
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
    public function assignRoleToUser(Request $request, int $id): JsonResponse
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
