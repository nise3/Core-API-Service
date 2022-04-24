<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Exceptions\HttpErrorException;
use App\Models\BaseModel;
use App\Models\Domain;
use App\Models\ForgetPasswordReset;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Common\SmsService;
use Throwable;

/**
 *
 */
class UserService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     * @throws Exception
     */
    public function getAllUsers(array $request, Carbon $startTime): array
    {
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

        ])->acl();

        /** auth user shouldn't show in user list*/
        $usersBuilder->where('users.id', '!=', Auth::id());


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
            "users.branch_id",
            "users.training_center_id",
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

        if ($user->user_type == BaseModel::INSTITUTE_USER) {
            $user['branch_id'] = $user->branch_id;
            $user['training_center_id'] = $user->training_center_id;
            $user['institute_user_type'] = $this->getIndustryUserType($user);
        }

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
     * @param string $username
     * @param Carbon $startTime
     * @return array
     */
    public function getUserByUsername(string $username, Carbon $startTime): array
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
            "users.email",
            "users.country",
            "users.phone_code",
            "users.mobile",
            "users.loc_division_id",
            "users.loc_district_id",
            "users.loc_upazila_id",
            "users.verification_code",
            "users.verification_code_verified_at",
            "users.verification_code_sent_at",
            "users.password",
            "users.profile_pic",
            "users.branch_id",
            "users.training_center_id",
            "users.row_status",
            "users.created_by",
            "users.updated_by",
            "users.created_at",
            "users.updated_at",
        ]);

        $user = $userBuilder->where('users.username', $username)->first();

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
     * @param string $id
     * @return array
     * @throws RequestException
     */
    public function getUserPermissionWithMenuItems(string $id): array
    {

        $user = User::where('idp_user_id', $id)->firstOrFail();

        $institute = null;
        $organization = null;
        $industryAssociation = null;
        $rto = null;
        $isSystemUser = $user->user_type == BaseModel::SYSTEM_USER;
        $isOrganizationUser = $user->user_type == BaseModel::ORGANIZATION_USER;
        $isInstituteUser = $user->user_type == BaseModel::INSTITUTE_USER;
        $isIndustryAssociationUser = $user->user_type == BaseModel::INDUSTRY_ASSOCIATION_USER;
        $isRegisteredTrainingOrganizationUser = $user->user_type == BaseModel::REGISTERED_TRAINING_ORGANIZATION_USER;

        if ($user->user_type == BaseModel::ORGANIZATION_USER && !is_null($user->organization_id)) {

            $url = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . 'service-to-service-call/organizations/' . $user->organization_id;

            $organization = Http::withOptions([
                'debug' => config("nise3.is_dev_mode"),
                'verify' => config("nise3.should_ssl_verify")
            ])
                ->timeout(5)
                ->get($url)
                ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                    Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                    Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                    throw new HttpErrorException($httpResponse);
                })
                ->json('data', []);

        } else if ($user->user_type == BaseModel::INSTITUTE_USER && !is_null($user->institute_id)) {

            $url = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . 'service-to-service-call/institutes/' . $user->institute_id;

            $institute = Http::withOptions([
                'debug' => config("nise3.is_dev_mode"),
                'verify' => config("nise3.should_ssl_verify")
            ])
                ->timeout(5)
                ->get($url)
                ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                    Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                    Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                    throw new HttpErrorException($httpResponse);
                })
                ->json('data', []);

        } else if ($user->user_type == BaseModel::INDUSTRY_ASSOCIATION_USER && !is_null($user->industry_association_id)) {

            $url = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . 'service-to-service-call/industry-associations/' . $user->industry_association_id;

            $industryAssociation = Http::withOptions([
                'debug' => config("nise3.is_dev_mode"),
                'verify' => config("nise3.should_ssl_verify")
            ])
                ->timeout(5)
                ->get($url)
                ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                    Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                    Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                    throw new HttpErrorException($httpResponse);
                })
                ->json('data', []);
        } else if ($user->user_type == BaseModel::REGISTERED_TRAINING_ORGANIZATION_USER && !is_null($user->registered_training_organization_id)) {

            $url = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . 'service-to-service-call/registered-training-organizations/' . $user->registered_training_organization_id;

            $rto = Http::withOptions([
                'debug' => config("nise3.is_dev_mode"),
                'verify' => config("nise3.should_ssl_verify")
            ])
                ->timeout(5)
                ->get($url)
                ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                    Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                    Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                    throw new HttpErrorException($httpResponse);
                })
                ->json('data', []);
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

        $result = [
            'userType' => BaseModel::USER_TYPE[$user->user_type],
            'isSystemUser' => $isSystemUser,
            'isInstituteUser' => $isInstituteUser,
            'isOrganizationUser' => $isOrganizationUser,
            'isIndustryAssociationUser' => $isIndustryAssociationUser,
            'isRegisteredTrainingOrganizationUser' => $isRegisteredTrainingOrganizationUser,
            'permissions' => $conditionalPermissions,
            'menu_items' => $menuItem,
            'role_id' => $user->role_id,
            'role' => $role,
            'institute_id' => $user->institute_id,
            'institute' => $institute,
            'organization_id' => $user->organization_id,
            'organization' => $organization,
            'industry_association_id' => $user->industry_association_id,
            'industry_association' => $industryAssociation,
            'registered_training_organization_id' => $user->registered_training_organization_id,
            'registered_training_organization' => $rto,
            'username' => $user->username,
            'displayName' => $user->name_en,
            'name' => $user->name,
            'profile_pic' => $user->profile_pic,
            'user_id' => $user->id,
            'domain' => $this->getDomain($user)
        ];

        if ($isInstituteUser) {
            $result['branch_id'] = $user->branch_id;
            $result['training_center_id'] = $user->training_center_id;
            $result['institute_user_type'] = $this->getIndustryUserType($user);
        }

        return $result;
    }

    private function getDomain(User $user)
    {
        $domain = request()->headers->get('Domain');
        $attr = '';
        if (str_ends_with($domain, 'nise.gov.bd')) {
            $attr = 'nise.gov.bd';
        } else if (str_ends_with($domain, '-staging.nise3.xyz')) {
            $attr = '-staging.nise3.xyz';
        } else if (str_ends_with($domain, '-dev.nise3.xyz')) {
            $attr = '-dev.nise3.xyz';
        } else if (str_ends_with($domain, 'nise.asm')) {
            $attr = 'nise.asm';
        }

        if ($user->isSystemUser()) {
            return $attr;
        }

        $builder = Domain::where('domain', 'like', '%\.' . $attr);

        if ($user->isInstituteUser()) {
            $builder->where('institute_id', $user->institute_id);
        } else if ($user->isOrganizationUser()) {
            $builder->where('organization_id', $user->organization_id);
        } else if ($user->isIndustryAssociationUser()) {
            $builder->where('industry_association_id', $user->industry_association_id);
        }

        $domainObj = $builder->first();

        return $domainObj ? $domainObj->domain : '';
    }


    public function getIndustryUserType(User $user): string
    {
        if ($user->training_center_id) {
            return 'training center';
        } else if ($user->branch_id) {
            return 'branch';
        }
        return 'institute';
    }


    /**
     * @param string|null $id
     * @return mixed
     */
    public function getAuthPermission(?string $id): mixed
    {
        $user = User::where('idp_user_id', $id)
            ->where('row_status', BaseModel::ROW_STATUS_ACTIVE)
            ->firstOrFail();

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
     * @throws Throwable
     */
    public function store(User $user, array $data): User
    {
        $user->fill($data);
        throw_if(!$user->save(), 'Saving user to DB is failed', 500);
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
     * @param Request $request
     */
    public function userApproval(Request $request)
    {
        $requestData = $request->all();
        Log::info(json_encode($requestData));
        $userType = $requestData['user_type'];
        $users = null;
        if ($userType == BaseModel::ORGANIZATION_USER) {
            $users = User::where('organization_id', $requestData['organization_id'])
                ->where('user_type', $userType)
                ->get();
        } elseif ($userType == BaseModel::INSTITUTE_USER) {
            $users = User::where('institute_id', $requestData['institute_id'])
                ->where('user_type', $userType)
                ->get();
        } elseif ($userType == BaseModel::INDUSTRY_ASSOCIATION_USER) {
            $users = User::where('industry_association_id', $requestData['industry_association_id'])
                ->where('user_type', $userType)
                ->get();
        }
        if (!empty($users)) {
            foreach ($users as $user) {
                Cache::forget($user->idp_user_id);

                /** default role will be created when the user is approved for first time */
                if (!empty($requestData['row_status']) && $requestData['row_status'] == BaseModel::ROW_STATUS_PENDING) {
                    $role = $this->createDefaultRole($requestData);
                    if ($role) {
                        $user->role_id = $role->id;
                    }
                }
                $user->row_status = BaseModel::ROW_STATUS_ACTIVE;
                $user->save();
            }
        }
        return $users;
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function userDelete(Request $request)
    {
        $requestData = $request->all();
        Log::info(json_encode($requestData));
        $userType = $requestData['user_type'];
        if (!empty($requestData['training_center_id'])) {
            $trainingCenterId = $requestData['training_center_id'];
        }
        if (!empty($requestData['branch_id'])) {
            $branchId = $requestData['branch_id'];
        }

        if ($userType == BaseModel::ORGANIZATION_USER) {
            $users = User::where('organization_id', $requestData['organization_id'])
                ->where('user_type', $userType)
                ->get();
        } elseif ($userType == BaseModel::INSTITUTE_USER) {
            /** @var Builder $userBuilder */
            $userBuilder = User::where('institute_id', $requestData['institute_id']);
            $userBuilder->where('user_type', $userType);
            if (!empty($trainingCenterId)) {
                $userBuilder->where('training_center_id', $trainingCenterId);
            }
            if (!empty($branchId)) {
                $userBuilder->where('branch_id', $branchId);
                $userBuilder->whereNull('training_center_id');
            }
            $users = $userBuilder->get();

        } elseif ($userType == BaseModel::INDUSTRY_ASSOCIATION_USER) {
            $users = User::where('industry_association_id', $requestData['industry_association_id'])
                ->where('user_type', $userType)
                ->get();
        }

        if (!empty($users)) {
            foreach ($users as $user) {
                $this->idpUserDelete($user->idp_user_id);
                Cache::forget($user->idp_user_id);
                $user->delete();
            }
        }
    }


    /**
     * @param Request $request
     */
    public function userRejection(Request $request)
    {
        $requestData = $request->all();
        Log::info(json_encode($requestData));
        $userType = $requestData['user_type'];
        $users = null;
        if ($userType == BaseModel::ORGANIZATION_USER) {
            $users = User::where('organization_id', $requestData['organization_id'])->get();
        } elseif ($userType == BaseModel::INSTITUTE_USER) {
            $users = User::where('institute_id', $requestData['institute_id'])->get();
        } elseif ($userType == BaseModel::INDUSTRY_ASSOCIATION_USER) {
            $users = User::where('industry_association_id', $requestData['industry_association_id'])->get();
        }
        if (!empty($users)) {
            foreach ($users as $user) {
                Cache::forget($user->idp_user_id);
                $user->row_status = BaseModel::ROW_STATUS_REJECT;
                $user->save();
            }

        }
        return $users;
    }


    /**
     * @param array $data
     * @return Role
     */
    private function createDefaultRole(array $data): Role
    {
        $data = [
            'key' => str_replace(' ', '_', $data['name_en']) . "_" . time(),
            'title_en' => $data['name_en'],
            'title' => $data['name'],
            'permission_sub_group_id' => $data['permission_sub_group_id'] ?? null,
            'organization_id' => $data['organization_id'] ?? null,
            'institute_id' => $data['institute_id'] ?? null,
            'industry_association_id' => $data['industry_association_id'] ?? null,
        ];

        $role = app(RoleService::class)->store($data);

        $permissionSubGroupPermissionIds = DB::table('permission_sub_group_permissions')
            ->where('permission_sub_group_id', $data['permission_sub_group_id'])
            ->pluck('permission_id')
            ->toArray();

        $role->permissions()->sync($permissionSubGroupPermissionIds);

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
    public function userOpenRegistrationValidator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "user_type" => "required|min:1",
            "username" => 'required|max:100|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|int',
            "institute_id" => 'nullable|int',
            "industry_association_id" => 'nullable|int',
            "registered_training_organization_id" => 'nullable|int',
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
     * @param array $data
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function adminUserCreateValidator(array $data, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'permission_sub_group_id' => 'required|int',
            "user_type" => "required|min:1",
            "username" => 'required|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|int',
            "institute_id" => 'nullable|int',
            "industry_association_id" => 'nullable|int',
            "registered_training_organization_id" => 'nullable|int',
            "trainer_id" => 'nullable|int',
            "role_id" => 'nullable|exists:roles,id',
            "name_en" => 'nullable|max:255|min:3',
            "name" => 'required|max:300|min:3',
            "email" => 'required|max:191|email',
            "mobile" => "nullable|max:15|string",
            "loc_division_id" => 'nullable|exists:loc_divisions,id,deleted_at,NULL',
            "loc_district_id" => 'nullable|exists:loc_districts,id,deleted_at,NULL',
            "loc_upazila_id" => 'nullable|exists:loc_upazilas,id,deleted_at,NULL',
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
        return Validator::make($data, $rules);
    }

    /**
     * @param array $data
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "user_type" => [
                'required',
                'min:1',
                Rule::in(BaseModel::USER_TYPES)
            ],
            "username" => [
                'required',
                'string',
                'unique:users,username,' . $id,
                BaseModel::USERNAME_REGEX
            ],
            "organization_id" => [
                'required_if:user_type,' . BaseModel::ORGANIZATION_USER,
                'nullable',
                'integer',
                'int',
                'gt:0'
            ],
            "institute_id" => [
                'required_if:user_type,' . BaseModel::INSTITUTE_USER,
                'nullable',
                'integer',
                'gt:0'
            ],
            "industry_association_id" => [
                'required_if:user_type,' . BaseModel::INDUSTRY_ASSOCIATION_USER,
                'nullable',
                'integer',
                'gt:0'
            ],
            "registered_training_organization_id" => [
                'required_if:user_type,' . BaseModel::REGISTERED_TRAINING_ORGANIZATION_USER,
                'nullable',
                'integer',
                'gt:0'
            ],
            "trainer_id" => [
                'nullable',
                'integer',
                'gt:0'
            ],
            'branch_id' => 'nullable|int|gt:0',
            'training_center_id' => 'nullable|int|gt:0',
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
            "loc_division_id" => 'nullable|gt:0|exists:loc_divisions,id,deleted_at,NULL',
            "loc_district_id" => 'nullable|gt:0|exists:loc_districts,id,deleted_at,NULL',
            "loc_upazila_id" => 'nullable|gt:0|exists:loc_upazilas,id,deleted_at,NULL',
            "verification_code" => 'nullable|string',
            "verification_code_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "verification_code_sent_at" => 'nullable|date_format:Y-m-d H:i:s',
            "profile_pic" => 'nullable|string',
            "created_by" => "nullable|int|gt:0",
            "updated_by" => "nullable|int|gt:0",
            "remember_token" => "nullable|string",
            'row_status' => [
                'required',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        if (!$id) {
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
        return Validator::make($data, $rules);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function passwordUpdatedValidator(Request $request, User $user): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'current_password' => [
                'required',
                'min:' . BaseModel::PASSWORD_MIN_LENGTH,
            ],
            'new_password' => [
                'required',
                'min:' . BaseModel::PASSWORD_MIN_LENGTH,
                BaseModel::PASSWORD_REGEX
            ],
            'new_password_confirmation' => [
                'required_with:new_password'
            ]

        ];
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
            "name_en" => 'nullable|min:3|max:255',
            "name" => 'required|min:3|max:500',
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
     * @param array $idpUserPayload
     * @return mixed
     * @throws Exception
     */
    public function idpUserCreate(array $idpUserPayload): mixed
    {
//        $payload = $this->prepareIdpPayload($idpUserPayload);

        Log::info("IDP_Payload is bellow", $idpUserPayload);

        /** response from idp server after user creation */
        $object = IdpUser()->setPayload($idpUserPayload);
        Log::debug('Class Name: ' . get_class($object));
        $response = $object->create()->get();

        return $response;
    }


    /**
     * Delete Idp User
     * @throws Exception
     */
    public function idpUserDelete(string $idpUserId): mixed
    {
        return IdpUser()
            ->use('wso2idp')
            ->setPayload($idpUserId)
            ->delete()
            ->get();
    }

    /**
     * Update Idp User
     * @param array $idpUserPayload
     * @return mixed
     * @throws Exception
     */
    public function idpUserUpdate(array $idpUserPayload): mixed
    {
        return IdpUser()
            ->setPayload($idpUserPayload)
            ->update()
            ->get();
    }

    /**
     * @param array $idpPasswordUpdatePayload
     * @return mixed
     * @throws Exception
     */
    public function idpUserPasswordUpdate(array $idpPasswordUpdatePayload): mixed
    {
        return IdpUser()->setPayload($idpPasswordUpdatePayload)->userResetPassword()->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function sendForgetPasswordOtpValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "username" => [
                'required'
            ]
        ];

        return Validator::make($request->all(), $rules);
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     * @throws Throwable
     */
    public function sendForgetPasswordOtpCode(array $data): bool
    {
        $username = $data["username"];
        //dd('userName eq '.$username);
        $response = IdpUser()->setPayload([
            'filter' => "userName eq $username",
        ])->findUsers()->get();


        $data = $response['data'];

        if ($data['totalResults'] == 1 && !empty($data['Resources'][0]['phoneNumbers'][0]['value'])) {

            $mobile = $data['Resources'][0]['phoneNumbers'][0]['value'];
            $code = generateOtp(6);
            $message = "Your forget password OTP code is : " . $code;

            $idpUserId = $data['Resources'][0]['id'];
            $username = $data['Resources'][0]['userName'];

            $forgetPass = app(ForgetPasswordReset::class);

            $forgetPass->updateOrCreate(['idp_user_id' => $idpUserId], [
                    'idp_user_id' => $idpUserId,
                    'username' => $username,
                    'forget_password_otp_code' => $code,
                    'forget_password_otp_code_sent_at' => Carbon::now()
                ]
            );

            if ($mobile) {
                $smsService = app(SmsService::class);
                $smsService->sendSms($mobile, $message);
            }
        }

        return false;
    }


}
