<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Facade\AuthUser;
use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
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
        $nameBn = $request['name'] ?? "";
        $email = $request['email'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $request['organization_id'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $userType = $request['user_type'] ?? "";

        /** @var User|Builder $usersBuilder */
        $usersBuilder = User::select([
            "users.id",
            'users.idp_user_id',
            "users.name_en",
            "users.name",
            "users.user_type",
            "users.username",
            "users.institute_id",
            "users.organization_id",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title as role_title',
            "users.email",
            "users.country",
            "users.phone_code",
            "users.mobile",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title as loc_divisions_title',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title as loc_district_title',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title as loc_upazila_title',
            "users.verification_code",
            "users.verification_code_verified_at",
            "users.verification_code_sent_at",
            "users.password",
            "users.profile_pic",
            "users.row_status",
            "users.created_by",
            "users.updated_by",
            "users.created_at",
            "users.updated_at",

        ]);

        $usersBuilder->leftJoin('roles', function ($join) use ($rowStatus) {
            $join->on('roles.id', '=', 'users.role_id')
                ->whereNull('roles.deleted_at');
        });

        $usersBuilder->leftJoin('loc_divisions', function ($join) use ($rowStatus) {
            $join->on('loc_divisions.id', '=', 'users.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $usersBuilder->leftJoin('loc_districts', function ($join) use ($rowStatus) {
            $join->on('loc_districts.id', '=', 'users.loc_district_id')
                ->whereNull('loc_districts.deleted_at');
        });

        $usersBuilder->leftJoin('loc_upazilas', function ($join) use ($rowStatus) {
            $join->on('loc_upazilas.id', '=', 'users.loc_upazila_id')
                ->whereNull('loc_upazilas.deleted_at');
        });

        $usersBuilder->orderBy('users.id', $order);

        if (!empty($nameEn)) {
            $usersBuilder = $usersBuilder->where('users.name_en', 'like', '%' . $nameEn . '%');
        }
        if (!empty($nameBn)) {
            $usersBuilder = $usersBuilder->where('users.name', 'like', '%' . $nameBn . '%');
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
            "users.name",
            "users.user_type",
            "users.username",
            "users.institute_id",
            "users.organization_id",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title as role_title',
            "users.email",
            "users.country",
            "users.phone_code",
            "users.mobile",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title as loc_divisions_title',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title as loc_district_title',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title as loc_upazila_title',
            "users.verification_code",
            "users.verification_code_verified_at",
            "users.verification_code_sent_at",
            "users.password",
            "users.profile_pic",
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

    /**
     * @throws RequestException
     */
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

            $responseData = Http::retry(3)
                ->withOptions(['debug' => config("nise3.is_dev_mode"), 'verify' => config("nise3.should_ssl_verify")])
                ->get($url)
                ->throw(function ($response, $exception) {
                    return $exception;
                })
                ->json();

            $organization = $responseData['data'] ?? [];

        } else if ($user->user_type == BaseModel::INSTITUTE_USER && !is_null($user->institute_id)) {

            $url = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . 'institutes/' . $user->institute_id;

            $responseData = Http::retry(3)
                ->withOptions(['debug' => config("nise3.is_dev_mode"), 'verify' => config("nise3.should_ssl_verify")])
                ->get($url)
                ->throw(function ($response, $exception) {
                    return $exception;
                })
                ->json();

            $institute = $responseData['data'] ?? [];
        }

        $role = Role::find($user->role_id);

        $rolePermissions = Role::where('id', $user->role_id ?? null)->with('permissions:key')->first();

        $permissions = $rolePermissions->permissions ?? [];

        $conditionalPermissions = [];

        foreach ($permissions as $permission) {
            $conditionalPermissions[] = $permission->key;
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
     * @return mixed
     */
    public function getAuthPermission(?string $id): mixed
    {
        $user = User::where('idp_user_id', $id)
            ->where('row_status', BaseModel::ROW_STATUS_ACTIVE)
            ->first();

        if (!$user) {
            return new \stdClass();
        }

        $role = Role::find($user->role_id);
        $rolePermissions = Role::where('id', $user->role_id ?? null)->with('permissions:key')->first();
        $permissions = $rolePermissions->permissions ?? [];
        $permissionKeys = [];
        foreach ($permissions as $permission) {
            $permissionKeys[] = $permission->key;
        }

        $user ["role"] = $role;
        $user ["permissions"] = collect($permissionKeys);

        return $user;
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
            'key' => str_replace(' ', '_', $data['name_en'])."_".time(),
            'title_en' => $data['name_en'],
            'title' => $data['name'],
            'permission_sub_group_id' => $data['permission_sub_group_id'] ?? null,
            'organization_id' => $data['organization_id'] ?? null,
            'institute_id' => $data['institute_id'] ?? null,
        ];

        $role = app(RoleService::class)->store($roleField);
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
        $user->save();
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

    /**
     * @param User $user
     * @param array $permissionIds
     * @return User
     */
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
            "organization_id" => 'nullable|int',
            "institute_id" => 'nullable|int',
            "name_en" => 'nullable|max:255|min:3',
            "name" => 'required|max:300|min:3',
            "email" => 'required|max:191|email',
            "mobile" => [
                "required",
                "string",
                BaseModel::MOBILE_REGEX
            ],
            "password" => [
                "required",
                Password::min(BaseModel::PASSWORD_MIN_LENGTH)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ];
        return Validator::make($request->all(), $rules);
    }


    /**
     * validation for organization or institute creation by admin
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function organizationOrInstituteUserCreateValidator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'permission_sub_group_id' => 'required|int',
            "user_type" => "required|min:1",
            "username" => 'required|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|int',
            "institute_id" => 'nullable|int',
            "role_id" => 'nullable|exists:roles,id',
            "name_en" => 'nullable|max:255|min:3',
            "name" => 'required|max:300|min:3',
            "email" => 'required|max:191|email',
            "mobile" => "nullable|max:15|string",
            "loc_division_id" => 'nullable|exists:loc_districts,id',
            "loc_district_id" => 'nullable|exists:loc_divisions,id',
            "loc_upazila_id" => 'nullable|exists:loc_upazilas,id',
            "verification_code_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "verification_code_sent_at" => 'nullable|date_format:Y-m-d H:i:s',
            "password" => [
                "required",
                Password::min(BaseModel::PASSWORD_MIN_LENGTH)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            "profile_pic" => 'nullable|max:1000|string',
            "created_by" => "nullable|int",
            "updated_by" => "nullable|int",
            "remember_token" => "nullable|string",
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],

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
            "username" => [
                'required',
                'string',
                'unique:users,username,' . $id,
                BaseModel::USERNAME_REGEX
            ],
            "organization_id" => 'nullable|int|gt:0',
            "institute_id" => 'nullable|int|gt:0',
            "role_id" => 'nullable|exists:roles,id',
            "name_en" => 'nullable|string|min:2',
            "name" => 'required|string|min:2',
            "country" => 'nullable|string|',
            "phone_code" => "nullable|string",
            "email" => 'required|email',
            "mobile" => [
                "required",
                "string",
                BaseModel::MOBILE_REGEX
            ],
            "loc_division_id" => 'nullable|gt:0|exists:loc_districts,id',
            "loc_district_id" => 'nullable|gt:0|exists:loc_divisions,id',
            "loc_upazila_id" => 'nullable|gt:0|exists:loc_upazilas,id',
            "verification_code" => 'nullable|string',
            "verification_code_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "verification_code_sent_at" => 'nullable|date_format:Y-m-d H:i:s',
            "profile_pic" => 'nullable|string',
            "created_by" => "nullable|int|gt:0",
            "updated_by" => "nullable|int|gt:0",
            "remember_token" => "nullable|string",
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        if(!$id){
            $rules['password'] = [
                'required',
                "confirmed",
                Password::min(BaseModel::PASSWORD_MIN_LENGTH)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ];
            $rules['password_confirmation'] = 'required_with:password';
        }
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function profileUpdatedValidator(Request $request, User $user): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "name_en" => 'required|min:3|max:255',
            "name" => 'required|min:3|max:500',
            "mobile" => [
                'nullable',
                BaseModel::MOBILE_REGEX
            ],
//            "current_password" => [
//                'required_with:password',
//                function ($attribute, $value, $fail) use ($user) {
//                    if (!Hash::check($value, $user->password)) {
//                        $fail('Your password was not updated, since the provided current password does not match.[46001]');
//                    }
//                }
//
//            ],
//            "password" => [
//                "required",
//                "confirmed",
//                'different:current_password',
//                Password::min(BaseModel::PASSWORD_MIN_LENGTH)
//                    ->letters()
//                    ->mixedCase()
//                    ->numbers(),
//            ],
//            "password_confirmation" => 'required_with:password',
            "profile_pic" => [
                'nullable',
                "string"
            ],
            "created_by" => "nullable|integer",
            "updated_by" => "nullable|integer",
        ];

        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function roleIdValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'role_id' => [
                'required',
                'exists:roles,id',
                'int',
                'min:1'
            ]
        ];
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function permissionValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $permissions = $request->input('permissions');
        $data = [];

        if ($permissions) {
            $data = [
                'permissions' => is_array($permissions) ? $permissions : explode(',', $permissions)
            ];
        }

        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|int|distinct|min:1'
        ];
        return Validator::make($data, $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0.[30000]'
        ];

        return Validator::make($request->all(), [
            'page' => 'int',
            'page_size' => 'int',
            'name_en' => 'nullable|string',
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            "organization_id" => 'nullable|int',
            "institute_id" => 'nullable|int',
            'user_type' => 'nullable|int',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "int",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

    /**
     * @para m array $data
     * @param array $data
     * @return PromiseInterface|\Illuminate\Http\Client\Response
     */
    public function idpUserCreate(array $data): PromiseInterface|\Illuminate\Http\Client\Response
    {
        $url = clientUrl(BaseModel::IDP_SERVER_CLIENT_URL_TYPE);
        $payload = $this->prepareIdpPayload($data);
        Log::info("IDP_Payload is bellow");
        Log::info(json_encode($payload));
        $client = Http::withBasicAuth(BaseModel::IDP_USERNAME, BaseModel::IDP_USER_PASSWORD)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->withOptions([
                'verify' => false
            ])
            ->post($url, $payload);

        Log::channel('idp_user')->info('idp_user_payload', $data);
        Log::channel('idp_user')->info('idp_user_info', $client->json());
        return $client;
    }

    private function prepareIdpPayload($data): array
    {
        $userEmailNo = trim($data['email']);
        $cleanUserName = trim($data['username']);
        return [
            'schemas' => [
                "urn:ietf:params:scim:schemas:core:2.0:User",
                "urn:ietf:params:scim:schemas:extension:enterprise:2.0:User"
            ],
            'name' => [
                'familyName' => $data['name'],
                'givenName' => $data['name']
            ],
            'active' => (string)$data['status'],
            'organization' => $data['name'],
            'userName' => $cleanUserName,
            'password' => $data['password'],
            'userType' => $data['user_type'],
            'country' => 'BD',
            'emails' => [
                0 => $userEmailNo
            ]
        ];
    }

}
