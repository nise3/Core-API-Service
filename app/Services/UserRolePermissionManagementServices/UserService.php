<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class UserService
{
    const ROUTE_PREFIX = 'api.v1.users.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllUsers(Request $request, Carbon $startTime): array
    {
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $nameEn = $request->query('name_en');
        $nameBn = $request->query('name_bn');
        $email = $request->query('email');

        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var User|Builder $users */
        $users = User::select([
            "users.*",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
        ]);
        $users->leftJoin('roles', 'roles.id', 'users.role_id');
        $users->leftJoin('loc_divisions', 'loc_divisions.id', 'users.loc_division_id');
        $users->leftJoin('loc_districts', 'loc_districts.id', 'users.loc_district_id');
        $users->leftJoin('loc_upazilas', 'loc_upazilas.id', 'users.loc_upazila_id');
        $users->orderBy('users.id', $order);

        if (!empty($nameEn)) {
            $users = $users->where('users.name_en', 'like', '%' . $nameEn . '%');
        }
        if (!empty($nameBn)) {
            $users = $users->where('users.name_bn', 'like', '%' . $nameBn . '%');
        }
        if (!empty($email)) {
            $users = $users->where('users.email', 'like', '%' . $email . '%');
        }
        $users->where('users.row_status', BaseModel::ROW_STATUS_ACTIVE);
        $users->orderBy('users.id', $order);

        if ($paginate || $limit) {
            $limit = $limit ?: 10;
            $users = $users->paginate($limit);
            $paginateData = (object)$users->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $users = $users->get();
        }
        $response['order'] = $order;
        $response['data'] = $users->toArray()['data'] ?? $users->toArray();
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
        /** @var User|Builder $user */
        $user = User::select([
            "users.*",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
        ]);
        $user->leftJoin('roles', 'roles.id', 'users.role_id');
        $user->leftJoin('loc_divisions', 'loc_divisions.id', 'users.loc_division_id');
        $user->leftJoin('loc_districts', 'loc_districts.id', 'users.loc_district_id');
        $user->leftJoin('loc_upazilas', 'loc_upazilas.id', 'users.loc_upazila_id');
        $user = $user->where('users.id', $id)->first();

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
     * @param array $data
     * @param User $user
     * @return User
     */
    public function store(User $user, array $data): User
    {
        return $user->create($data);
    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function update(array $data, User $user): User
    {
        $data['password'] = Hash::make($data['password']);
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
        $user->permissions()->syncWithoutDetaching($validPermissions);
        return $user;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return Validator
     */
    public function validator(Request $request, int $id = null): Validator
    {
        $rules = [
            "user_type" => "required|min:1",
            "username" => 'required|string|unique:users,username,' . $id,
            "organization_id" => 'nullable|numeric',
            "institute_id" => 'nullable|numeric',
            "role_id" => 'nullable|exists:roles,id',
            "name_en" => 'required|min:3',
            "name_bn" => 'required|min:3',
            "email" => 'required|email|unique:users,email,' . $id,
            "mobile" => "nullable|string",
            "loc_division_id" => 'nullable|exists:loc_districts,id',
            "loc_district_id" => 'nullable|exists:loc_divisions,id',
            "loc_upazila_id" => 'nullable|exists:loc_upazilas,id',
            "email_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "mobile_verified_at" => 'nullable|date_format:Y-m-d H:i:s',
            "password" => 'nullable|min:6',
            "profile_pic" => 'nullable|string',
            "created_by" => "nullable|numeric",
            "updated_by" => "nullable|numeric",
            "remember_token" => "nullable|string",
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],

        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function roleIdValidation(Request $request): Validator
    {
        $rules = [
            'role_id' => 'required|numeric|min:1|exists:roles,id',
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function permissionValidation(Request $request): Validator
    {
        $data["permissions"] = is_array($request['permissions']) ? $request['permissions'] : explode(',', $request['permissions']);
        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|numeric|distinct|min:1'
        ];
        return \Illuminate\Support\Facades\Validator::make($data, $rules);
    }
}
