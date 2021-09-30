<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Facade\AuthUser;
use App\Helpers\Classes\FileHandler;
use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\Common\HttpClient;
use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class UserService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllUsers(array $request, Carbon $startTime): array
    {
        $authUser = AuthUser::getUser();
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $nameEn = $request['name_en'] ?? "";
        $nameBn = $request['name_bn'] ?? "";
        $email = $request['email'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $authUser->organization_id ?? "";
        $instituteId = $authUser->institute_id ?? "";
        $userType = $authUser->user_type ?? "";

        /** @var User|Builder $usersBuilder */
        $usersBuilder = User::select([
            "users.id",
            'users.idp_user_id',
            "users.name_en",
            "users.name_bn",
            "users.user_type",
            "users.username",
            "users.institute_id",
            "users.organization_id",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            "users.email",
            "users.mobile",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
            "users.email_verified_at",
            "users.mobile_verified_at",
            "users.password",
            "users.row_status",
            "users.created_by",
            "users.updated_by",
            "users.created_at",
            "users.updated_at",

        ]);

        $usersBuilder->leftJoin('roles', function ($join) use ($rowStatus) {
            $join->on('roles.id', '=', 'users.role_id')
                ->whereNull('roles.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('roles.row_status', $rowStatus);
            }
        });

        $usersBuilder->leftJoin('loc_divisions', function ($join) use ($rowStatus) {
            $join->on('loc_divisions.id', '=', 'users.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('roles.row_status', $rowStatus);
            }
        });

        $usersBuilder->leftJoin('loc_districts', function ($join) use ($rowStatus) {
            $join->on('loc_districts.id', '=', 'users.loc_district_id')
                ->whereNull('loc_districts.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('roles.row_status', $rowStatus);
            }
        });

        $usersBuilder->leftJoin('loc_upazilas', function ($join) use ($rowStatus) {
            $join->on('loc_upazilas.id', '=', 'users.loc_upazila_id')
                ->whereNull('loc_upazilas.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('roles.row_status', $rowStatus);
            }
        });

        $usersBuilder->orderBy('users.id', $order);

        if (!empty($nameEn)) {
            $usersBuilder = $usersBuilder->where('users.name_en', 'like', '%' . $nameEn . '%');
        }
        if (!empty($nameBn)) {
            $usersBuilder = $usersBuilder->where('users.name_bn', 'like', '%' . $nameBn . '%');
        }
        if (!empty($email)) {
            $usersBuilder = $usersBuilder->where('users.email', 'like', '%' . $email . '%');
        }

        if (is_numeric($rowStatus)) {
            $usersBuilder->where('users.row_status', $rowStatus);
        }
        if (is_numeric($organizationId)) {
            $usersBuilder->where('users.organization_id', $organizationId);
        }
        if (is_numeric($instituteId)) {
            $usersBuilder->where('users.institute_id', $instituteId);
        }

        if (is_numeric($userType) && in_array($userType, BaseModel::USER_TYPES)) {
            $usersBuilder->where('users.user_type', $userType);
        }
        $response['order'] = $order;
        if ($authUser) {
            if (is_numeric($paginate) || is_numeric($pageSize)) {
                $pageSize = $pageSize ?: 10;
                $users = $usersBuilder->paginate($pageSize);
                $paginateData = (object)$users->toArray();
                $response['data'] = $users->toArray()['data'] ?? [];
                $response['current_page'] = $paginateData->current_page;
                $response['total_page'] = $paginateData->last_page;
                $response['page_size'] = $paginateData->per_page;
                $response['total'] = $paginateData->total;
            } else {
                $users = $usersBuilder->get();
                $response['data'] = $users->toArray() ?? [];
            }
        } else {
            $response['data'] = [];
        }

        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffForHumans(Carbon::now())
        ];
        return $response;
    }

    /**
     * @param int $id
     * @param Carbon $startTime
     * @return array
     */
    public function getOneUser(int $id, Carbon $startTime): array
    {
        /** @var User|Builder $userBuilder */
        $userBuilder = User::select([
            "users.id",
            'users.idp_user_id',
            "users.name_en",
            "users.name_bn",
            "users.user_type",
            "users.username",
            "users.organization_id",
            "users.institute_id",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            "users.email",
            "users.mobile",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
            "users.email_verified_at",
            "users.mobile_verified_at",
            "users.password",
            "users.row_status",
            "users.created_by",
            "users.updated_by",
            "users.created_at",
            "users.updated_at",
        ]);

        $userBuilder->leftJoin('roles', function ($join) {
            $join->on('roles.id', '=', 'users.role_id')
                ->whereNull('roles.deleted_at');
        });

        $userBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'users.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $userBuilder->leftJoin('loc_districts', function ($join) {
            $join->on('loc_districts.id', '=', 'users.loc_district_id')
                ->whereNull('loc_districts.deleted_at');
        });

        $userBuilder->leftJoin('loc_upazilas', function ($join) {
            $join->on('loc_upazilas.id', '=', 'users.loc_upazila_id')
                ->whereNull('loc_upazilas.deleted_at');
        });

        $user = $userBuilder->where('users.id', $id)->first();

        return [
            "data" => $user ?: null,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];
    }

    public function getUserPermissionWithMenuItems(string $id): array
    {
        $user = User::where('idp_user_id', $id)->first();

        if ($user == null)
            return [];

        $institute = null;
        $organization = null;
        $isSystemUser = $user->user_type == BaseModel::SYSTEM_USER;
        $isOrganizationUser = $user->user_type == BaseModel::ORGANIZATION_USER;
        $isInstituteUser = $user->user_type == BaseModel::INSTITUTE_USER;

        if ($user->user_type == BaseModel::ORGANIZATION_USER && !is_null($user->organization_id)) {

            $url = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . 'organizations/' . $user->organization_id;

            $responseData = Http::retry(3)->get($url)->throw(function ($response, $exception) {
                return $exception;
            })->json();

            $organization = $responseData['data'] ?? [];

        } else if ($user->user_type == BaseModel::INSTITUTE_USER && !is_null($user->institute_id)) {

            $url = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . 'institutes/' . $user->institute_id;

            $responseData = Http::retry(3)->get($url)->throw(function ($response, $exception) {
                return $exception;
            })->json();

            $institute = $responseData['data'] ?? [];
        }

        $role = Role::find($user->role_id);

        $rolePermissions = Role::where('id', $user->role_id ?? null)->with('permissions:name')->first();

        $permissions = $rolePermissions->permissions ?? [];

        $conditionalPermissions = [];

        foreach ($permissions as $permission) {
            $conditionalPermissions[] = $permission->name;
        }
        /** @var  $menuItemBuilder */
        $menuItemBuilder = DB::table('menu_items')->select([
            "menus.name as menu_name",
            "menu_items.title",
            "menu_items.type",
            "menu_items.title_lang_key",
            "menu_items.permission_key",
            "menu_items.url",
            "menu_items.target",
            "menu_items.icon_class",
            "menu_items.color",
            "menu_items.parent_id",
            "menu_items.order",
            "menu_items.route",
            "menu_items.parameters",
        ]);
        $menuItemBuilder->leftJoin('menus', 'menus.id', '=', 'menu_items.menu_id');
        $menuItemBuilder->whereIn('permission_key', $conditionalPermissions);
        $menuItemBuilder->orWhereNull('permission_key');
        $menuItem = $menuItemBuilder->get()->toArray();
        return [
            'userType' => BaseModel::USER_TYPE[$user->user_type],
            'isSystemUser' => $isSystemUser,
            'isInstituteUser' => $isInstituteUser,
            'isOrganizationUser' => $isOrganizationUser,
            'permissions' => $conditionalPermissions,
            'menu_items' => $menuItem,
            'role_id' => $user->role_id,
            'role' => $role,
            'institute_id' => $user->institute_id,
            'institute' => $institute,
            'organization_id' => $user->organization_id,
            'organization' => $organization,
            'username' => $user->username,
            'displayName' => $user->name_en

        ];
    }


    /**
     * @param string|null $id
     * @return array
     */
    public function getAuthPermission(?string $id): array
    {
        $user = User::where('idp_user_id', $id)->first();

        if ($user == null)
            return [];

        $role = Role::find($user->role_id);
        $rolePermissions = Role::where('id', $user->role_id ?? null)->with('permissions:name')->first();
        $permissions = $rolePermissions->permissions ?? [];
        $permissionKeys = [];
        foreach ($permissions as $permission) {
            $permissionKeys[] = $permission->name;
        }

        return [
            'user' => $user,
            'role' => $role,
            'permissions' => $permissionKeys
        ];
    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function store(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();
        return $user;
    }


    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function createRegisterUser(User $user, array $data): User
    {
        $role = $this->createDefaultRole($data);

        if ($role) {
            $data['role_id'] = $role->id;
        }
        $user->fill($data);
        $user->save();
        return $user;
    }


    /**
     * @param array $data
     * @return Role
     */
    private function createDefaultRole(array $data): Role
    {
        $roleService = new RoleService();

        $roleField = [
            'key' => str_replace('', '_', $data['name_en']),
            'title_en' => $data['name_en'],
            'title_bn' => $data['name_bn'],
            'permission_sub_group_id' => $data['permission_sub_group_id'] ?? null,
            'organization_id' => $data['organization_id'] ?? null,
            'institute_id' => $data['institute_id'] ?? null,
        ];

        $role = Role::updateOrCreate(
            ['key' => $roleField['key']],
            $roleField
        );
        $permissionSubGroupPermissionIds = DB::table('permission_sub_group_permissions')
            ->where('permission_sub_group_id', $data['permission_sub_group_id'])
            ->pluck('permission_id')
            ->toArray();
        $roleService->assignPermission($role, $permissionSubGroupPermissionIds);

        return $role;
    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function update(array $data, User $user): User
    {
        $user->fill($data);
        $user->save($data);
        return $user;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function destroy(User $user): bool
    {
        return $user->delete();
    }

    /**
     * @param User $user
     * @param int $role_id
     * @return User
     */
    public function setRole(User $user, int $role_id): User
    {
        $user->role_id = $role_id;
        $user->save();
        return $user;
    }

    public function assignPermission(User $user, array $permissionIds): User
    {
        $validPermissions = Permission::whereIn('id', $permissionIds)->orderBy('id', 'ASC')->pluck('id')->toArray();
        $user->permissions()->sync($validPermissions);
        return $user;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function registerUserValidator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "user_type" => "required|min:1",
            "username" => 'required|max:100|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|numeric',
            "institute_id" => 'nullable|numeric',
            "name_en" => 'required|max:255|min:3',
            "name_bn" => 'required|max:300|min:3',
            "email" => 'required|max:191|email',
            "mobile" => [
                "required",
                "string",
                BaseModel::MOBILE_REGEX
            ],
            "password" => "required|string|min:6"
        ];
        return Validator::make($request->all(), $rules);

    }

    public function organizationOrInstituteUserValidator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'permission_sub_group_id' => 'required|numeric',
            "user_type" => "required|min:1",
            "username" => 'required|max:100|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|numeric',
            "institute_id" => 'nullable|numeric',
            "name_en" => 'required|max:255|min:3',
            "name_bn" => 'required|max:300|min:3',
            "email" => 'required|max:191|email',
            "mobile" => [
                "nullable",
                "string",
                BaseModel::MOBILE_REGEX
            ]
        ];
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "user_type" => "required|min:1",
            "username" => 'required|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|numeric|gt:0',
            "institute_id" => 'nullable|numeric|gt:0',
            "role_id" => 'nullable|exists:roles,id',
            "name_en" => 'required|string|min:3',
            "name_bn" => 'required|string|min:3',
            "email" => 'required|email',
            "mobile" => [
                "nullable",
                "string",
                BaseModel::MOBILE_REGEX
            ],
            "loc_division_id" => 'nullable|gt:0|exists:loc_districts,id',
            "loc_district_id" => 'nullable|gt:0|exists:loc_divisions,id',
            "loc_upazila_id" => 'nullable|gt:0|exists:loc_upazilas,id',
            "email_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "mobile_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "password" => [
                'required_if:' . $id . ',==,null',
                'string'
            ],
            "profile_pic" => 'nullable|string',
            "created_by" => "nullable|numeric|gt:0",
            "updated_by" => "nullable|numeric|gt:0",
            "remember_token" => "nullable|string",
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function profileUpdatedvalidator(Request $request, User $user): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "name_en" => 'required|min:3|max:255',
            "name_bn" => 'required|min:3|max:500',
            "mobile" => [
                'nullable',
                BaseModel::MOBILE_REGEX
            ],
            "current_password" => [
                'required_with:password',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail([
                            [
                                "code" => 46001,
                                "message" => 'Your password was not updated, since the provided current password does not match.'
                            ]
                        ]);
                    }
                }

            ],
            "password" => [
                'required_with:password_confirmation',
                'string',
                'different:current_password',
                'confirmed'
            ],
            "password_confirmation" => 'required_with:password',
            "profile_pic" => [
                'nullable',
                "string"
            ],
            "created_by" => "nullable|numeric",
            "updated_by" => "nullable|numeric",
        ];

        return Validator::make($request->all(), $rules);
    }

    public function roleIdValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'role_id' => 'required|numeric|min:1|exists:roles,id',
        ];
        return Validator::make($request->all(), $rules);
    }

    public function permissionValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $data["permissions"] = is_array($request['permissions']) ? $request['permissions'] : explode(',', $request['permissions']);
        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|numeric|distinct|min:1'
        ];
        return Validator::make($data, $rules);
    }

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];

        return Validator::make($request->all(), [
            'page' => 'numeric',
            'page_size' => 'numeric',
            'name_en' => 'string',
            'name_bn' => 'string',
            'email' => 'string',
            "organization_id" => 'nullable|numeric',
            "institute_id" => 'nullable|numeric',
            'user_type' => 'nullable|numeric',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

    /**
     * @para m array $data
     * @return PromiseInterface|\Illuminate\Http\Client\Response
     */
    public function idpUserCreate(array $data)
    {
        $url = clientUrl(BaseModel::IDP_SERVER_CLIENT_URL_TYPE);

        $client = Http::withBasicAuth(BaseModel::IDP_USERNAME, BaseModel::IDP_USER_PASSWORD)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])->withOptions([
                'verify' => false
            ])->post($url, [
                'schemas' => [
                ],
                'name' => [
                    'familyName' => $data['name'],
                    'givenName' => $data['name']
                ],
                'userName' => $data['username'],
                'password' => $data['password'],
                'emails' => [
                    0 => [
                        'primary' => true,
                        'value' => $data['email'],
                        'type' => 'work',
                    ]
                ],
            ]);

        Log::channel('idp_user')->info('idp_user_payload', $data);
        Log::channel('idp_user')->info('idp_user_info', $client->json());

        return $client;

    }


}
