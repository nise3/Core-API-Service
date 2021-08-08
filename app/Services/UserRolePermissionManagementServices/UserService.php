<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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
        $paginateLink = [];
        $page = [];
        $paginate = $request->query('page');
        $nameEn = $request->query('name_en');
        $nameBn = $request->query('name_bn');
        $email = $request->query('email');

        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var User|Builder $users */
        $users = User::select([
            "users.id",
            "users.name_en",
            "users.name_bn",
            "users.email",
            "users.profile_pic",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            "users.organization_id",
            "users.institute_id",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            "users.loc_upazila_id",
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
        $users->where('users.row_status', User::ROW_STATUS_ACTIVE);
        $users->orderBy('users.id', $order);

        if (!empty($paginate)) {
            $users = $users->paginate(10);
            $paginateData = (object)$users->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $users = $users->get();
        }

        $data = [];
        foreach ($users as $user) {
            $links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $user->id]);
            $links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $user->id]);
            $links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $user->id]);
            $user['_links'] = $links;
            $data[] = $user->toArray();
        }
        return [
            "data" => $data ?: null,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ],
            "_links" => [
                'paginate' => $paginateLink,
                'search' => [
                    'parameters' => [
                        'name',
                        'key'
                    ],
                    '_link' => route(self::ROUTE_PREFIX . 'get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];
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
            "users.id",
            "users.name_en",
            "users.name_bn",
            "users.email",
            "users.profile_pic",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            "users.organization_id",
            "users.institute_id",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
        ]);
        $user->leftJoin('roles', 'roles.id', 'users.role_id');
        $user->leftJoin('loc_divisions', 'loc_divisions.id', 'users.loc_division_id');
        $user->leftJoin('loc_districts', 'loc_districts.id', 'users.loc_district_id');
        $user->leftJoin('loc_upazilas', 'loc_upazilas.id', 'users.loc_upazila_id');
        $user = $user->where('users.id', $id)->first();

        $links = [];
        if (!empty($user)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $user->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $user->id])
            ];
        }
        return [
            "data" => $user ?: null,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ],
            "_links" => $links
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
            "role_id" => 'nullable|exists:roles,id',
            "name_en" => 'required|min:3',
            "name_bn" => 'required|min:3',
            "organization_id" => 'nullable|numeric',
            "institute_id" => 'nullable|numeric',
            "loc_district_id" => 'nullable|exists:loc_divisions,id',
            "loc_division_id" => 'nullable|exists:loc_districts,id',
            "loc_upazila_id" => 'nullable|exists:loc_upazilas,id',
            "password" => 'nullable|min:6'
        ];
        if (!empty($id)) {
            $rules['email'] = 'required|email|unique:users,email,' . $id;
        } else {
            $rules['email'] = 'required|email|unique:users,email';
        }
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
        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|numeric|distinct|min:1'
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }
}
