<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RoleService
{
    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllRoles(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Role|Builder $roles */
        $roles = Role::select([
            'roles.id',
            'roles.title_bn',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.permission_group_id',
            'roles.organization_id',
            'roles.institute_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
            'roles.row_status',
            'roles.created_at',
            'roles.updated_at'
        ]);
        $roles->leftJoin('permission_groups', 'permission_groups.id', 'roles.permission_group_id');
        $roles->orderBy('roles.id', $order);

        if (!empty($titleEn)) {
            $roles->where('roles.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $roles->where('roles.title_bn', 'like', '%' . $titleBn . '%');
        }

        if ($paginate || $limit) {
            $limit = $limit ?: 10;
            $roles = $roles->paginate($limit);
            $paginateData = (object)$roles->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $roles = $roles->get();
        }
        $response['order'] = $order;
        $response['data'] = $roles->toArray()['data'] ?? $roles->toArray();
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
    public function getOneRole(int $id, Carbon $startTime): array
    {
        /** @var Role|Builder $role */
        $role = Role::select([
            'roles.id',
            'roles.title_bn',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.permission_group_id',
            'roles.organization_id',
            'roles.institute_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
            'roles.row_status',
            'roles.created_at',
            'roles.updated_at'
        ]);
        $role->leftJoin('permission_groups', 'permission_groups.id', 'roles.permission_group_id');
        $role->where('roles.id', $id);
        $role = $role->first();

        return [
            "data" => $role ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]

        ];
    }


    /**
     * @param array $data
     * @return Role
     */
    public function store(array $data): Role
    {
        $role = new Role();
        $role->fill($data);
        $role->save();
        return $role;
    }

    /**
     * @param Role $role
     * @param array $data
     * @return Role
     */
    public function update(Role $role, array $data): Role
    {
        $role->fill($data);
        $role->save();
        return $role;
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function destroy(Role $role): bool
    {
        return $role->delete();
    }

    /**
     * @param Role $role
     * @param array $permissionIds
     * @return Role
     */
    public function assignPermission(Role $role, array $permissionIds): Role
    {
        $validPermissions = Permission::whereIn('id', $permissionIds)->orderBy('id', 'ASC')->pluck('id')->toArray();
        $role->permissions()->syncWithoutDetaching($validPermissions);
        return $role;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            'description' => 'nullable',
            'permission_group_id' => 'nullable|exists:permission_groups,id',
            'organization_id' => 'nullable|numeric',
            'institute_id' => 'nullable|numeric',
            'key' => 'required|min:2|unique:roles,key,' . $id,
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
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
}
