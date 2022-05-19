<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $request['organization_id'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";

        /** @var Role|Builder $rolesBuilder */
        $rolesBuilder = Role::select([
            'roles.id',
            'roles.title',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.organization_id',
            'roles.industry_association_id',
            'roles.institute_id',
            'roles.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title as permission_group_title',
            'roles.permission_sub_group_id',
            'permission_sub_groups.title_en as permission_sub_group_title_en',
            'permission_sub_groups.title as permission_sub_group_title',
            'roles.row_status',
            'roles.created_at',
            'roles.updated_at',

        ])->acl();

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

        if (is_numeric($organizationId)) {
            $rolesBuilder->where('roles.organization_id', $organizationId);
        }
        if (is_numeric($industryAssociationId)) {
            $rolesBuilder->where('roles.industry_association_id', $industryAssociationId);
        }
        if (is_numeric($instituteId)) {
            $rolesBuilder->where('roles.institute_id', $instituteId);
        }

        $rolesBuilder->orderBy('roles.id', $order);

        if (!empty($titleEn)) {
            $rolesBuilder->where('roles.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $rolesBuilder->where('roles.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $roles */
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

    public function getAllRoleForFourIR(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $request['organization_id'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";

        /** @var Role|Builder $rolesBuilder */
        $rolesBuilder = Role::select([
            'roles.id',
            'roles.title',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.organization_id',
            'roles.industry_association_id',
            'roles.institute_id',
            'roles.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title as permission_group_title',
            'roles.permission_sub_group_id',
            'permission_sub_groups.title_en as permission_sub_group_title_en',
            'permission_sub_groups.title as permission_sub_group_title',
            'roles.row_status',
            'roles.created_at',
            'roles.updated_at',

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

        if (is_numeric($organizationId)) {
            $rolesBuilder->where('roles.organization_id', $organizationId);
        }
        if (is_numeric($industryAssociationId)) {
            $rolesBuilder->where('roles.industry_association_id', $industryAssociationId);
        }
        if (is_numeric($instituteId)) {
            $rolesBuilder->where('roles.institute_id', $instituteId);
        }
        /** Four Ir Roles by Permission Group id */
        $rolesBuilder->where("permission_groups.id", BaseModel::FOUR_PERMISSION_GROUP_ID);

        $rolesBuilder->orderBy('roles.id', $order);

        if (!empty($titleEn)) {
            $rolesBuilder->where('roles.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $rolesBuilder->where('roles.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $roles */
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
            'roles.title',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.organization_id',
            'roles.institute_id',
            'roles.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title as permission_group_title',
            'roles.permission_sub_group_id',
            'permission_sub_groups.title_en as permission_sub_group_title_en',
            'permission_sub_groups.title as permission_sub_group_title',
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
        $roleBuilder->with('permissions');
        $roleBuilder->where('roles.id', $id);

        /** @var Role $role */
        $role = $roleBuilder->firstOrFail();

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
        $role = app(Role::class);
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
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0.[30000]'
        ];

        $rules = [
            'title_en' => 'required|max:191|min:2',
            'title' => 'required|max:300|min:2',
            'description' => 'nullable|string',
            'permission_group_id' => ['nullable', 'exists:permission_groups,id'],
            'permission_sub_group_id' => ['nullable', 'exists:permission_sub_groups,id'],
            'organization_id' => 'nullable|int|gt:0',
            'industry_association_id' => 'nullable|int|gt:0',
            'institute_id' => 'nullable|int|gt:0',
            'key' => ['required', 'unique:roles,key,' . $id, 'min:2'],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

    public function permissionValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $permissions = $request->input('permissions');

        $data = [
            'permissions' => is_array($permissions) ? $permissions : explode(',', $permissions)
        ];

        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|int|distinct|min:1'
        ];
        return Validator::make($data, $rules);
    }

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
            'title_en' => 'nullable|max:191|min:2',
            'title' => 'nullable|max:300|min:2',
            "organization_id" => 'nullable|int|gt:0',
            "institute_id" => 'nullable|int|gt:0',
            'industry_association_id' => 'nullable|int|gt:0',
            'page' => 'int|gt:0',
            'page_size' => 'int|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "int",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
