<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RoleService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllRoles(array $request, Carbon $startTime): array
    {
        $titleEn = array_key_exists('title_en', $request) ? $request['title_en'] : "";
        $titleBn = array_key_exists('title_bn', $request) ? $request['title_bn'] : "";
        $paginate = array_key_exists('page', $request) ? $request['page'] : "";
        $pageSize = array_key_exists('page_size', $request) ? $request['page_size'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

        /** @var Role|Builder $rolesBuilder */
        $rolesBuilder = Role::select([
            'roles.id',
            'roles.title_bn',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.organization_id',
            'roles.institute_id',
            'roles.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
            'roles.permission_sub_group_id',
            'permission_sub_groups.title_en as permission_sub_group_title_en',
            'permission_sub_groups.title_bn as permission_sub_group_title_bn',
            'roles.row_status',
            'roles.created_at',
        ]);
        $rolesBuilder->leftJoin('permission_groups', function ($join) use ($rowStatus) {
            $join->on('permission_groups.id', '=', 'roles.permission_group_id');
            if (is_numeric($rowStatus)) {
                $join->where('permission_groups.row_status', $rowStatus);
            }
        });
        $rolesBuilder->leftJoin('permission_sub_groups', function ($join) use ($rowStatus) {
            $join->on('permission_sub_groups.id', '=', 'roles.permission_sub_group_id');
            if (is_numeric($rowStatus)) {
                $join->where('permission_sub_groups.row_status', $rowStatus);
            }
        });

        if (is_numeric($rowStatus)) {
            $rolesBuilder->where('roles.row_status', $rowStatus);
        }

        $rolesBuilder->orderBy('roles.id', $order);

        if (!empty($titleEn)) {
            $rolesBuilder->where('roles.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $rolesBuilder->where('roles.title_bn', 'like', '%' . $titleBn . '%');
        }

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $roles = $rolesBuilder->paginate($pageSize);
            $paginateData = (object)$roles->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $roles = $rolesBuilder->get();
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
        /** @var Role|Builder $roleBuilder */
        $roleBuilder = Role::select([
            'roles.id',
            'roles.title_bn',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.organization_id',
            'roles.institute_id',
            'roles.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
            'roles.permission_sub_group_id',
            'permission_sub_groups.title_en as permission_sub_group_title_en',
            'permission_sub_groups.title_bn as permission_sub_group_title_bn',
            'roles.row_status',
            'roles.created_at',
            'roles.updated_at'
        ]);
        $roleBuilder->leftJoin('permission_groups', function ($join) {
            $join->on('permission_groups.id', '=', 'roles.permission_group_id');
        });
        $roleBuilder->leftJoin('permission_sub_groups', function ($join) {
            $join->on('permission_sub_groups.id', '=', 'roles.permission_sub_group_id');
        });

        if (!empty($id)) {
            $roleBuilder->where('roles.id', $id);
        }
        $role = $roleBuilder->first();

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
        $role->permissions()->sync($validPermissions);
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
            'permission_sub_group_id' => 'nullable|exists: permission_sub_groups,id',
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

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC',
            'row_status.in' => 'Row status must be within 1 or 0'
        ];

        return Validator::make($request->all(), [
            'title_en' => 'nullable|min:1',
            'title_bn' => 'nullable|min:1',
            'page' => 'numeric',
            'page_size' => 'numeric',
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
}
