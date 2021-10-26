<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\InstitutePermission;
use App\Models\OrganizationPermission;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class PermissionService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissions(array $request, Carbon $startTime): array
    {
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $key = $request['key'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $method = $request['method'] ?? "";
        $uri = $request['uri'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'permissions.id',
            'permissions.title_en',
            'permissions.title',
            'permissions.module',
            'permissions.key',
            'permissions.uri',
            'permissions.method',
            'permissions.row_status',
            'permissions.created_at',
            'permissions.updated_at'
        ]);

        $permissionBuilder->orderBy('permissions.id', $order);

        if (!empty($key)) {
            $permissionBuilder->where('permissions.key', 'like', '%' . $key . '%');
        }

        if (!empty($titleEn)) {
            $permissionBuilder->where('permissions.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($title)) {
            $permissionBuilder->where('permissions.title', 'like', '%' . $title . '%');
        }

        if (!empty($uri)) {
            $permissionBuilder->where('permissions.uri', 'like', '%' . $uri . '%');
        }

        if (is_numeric($method)) {
            $permissionBuilder->where('permissions.method', '=', $method);
        }

        if (is_numeric($rowStatus)) {
            $permissionBuilder->where('permissions.row_status', $rowStatus);
        }

        /** @var Collection|Permission $permissions */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $permissions = $permissionBuilder->paginate($pageSize);
            $paginateData = (object)$permissions->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $permissions = $permissionBuilder->get();
        }
        $response['order'] = $order;
        $response['data'] = $permissions->toArray()['data'] ?? $permissions->toArray();

        foreach ($response['data'] as $index => $item) {
            $mn = $this->getMethodName($item["method"]);
            $response['data'][$index] = array_merge($response['data'][$index], ["method_name" => $mn]);
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
    public function getOnePermission(int $id, Carbon $startTime): array
    {
        /** @var Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'permissions.id',
            'permissions.title_en',
            'permissions.title',
            'permissions.module',
            'permissions.key',
            'permissions.uri',
            'permissions.method',
            'permissions.row_status',
            'permissions.created_at',
            'permissions.updated_at'
        ]);

        $permissionBuilder->where('permissions.id', $id);


        $permission = $permissionBuilder->first();

        return [
            "data" => $permission ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]

        ];
    }

    /**
     * @param Permission $permission
     * @param array $data
     * @return Permission
     */
    public function store(Permission $permission, array $data): Permission
    {
        $permission->fill($data);
        $permission->save();
        return $permission;
    }

    /**
     * @param array $data
     * @param Permission $permission
     * @return Permission
     */
    public function update(array $data, Permission $permission): Permission
    {
        $permission->fll($data);
        $permission->save();
        return $permission;
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function destroy(Permission $permission): bool
    {
        return $permission->delete();
    }

    /**
     * @param $item
     * @return string
     */
    private function getMethodName($item): string
    {
        return match ($item) {
            1 => "GET",
            2 => "POST",
            3 => "PUT",
            4 => "PATCH",
            5 => "DELETE",
            default => "",
        };
    }

    /**
     * @param int $organizationId
     * @param array $permissionIds
     * @return array
     */
    public function setPermissionToOrganization(int $organizationId, array $permissionIds): array
    {
        /** @var Collection|Permission $validPermissions */
        $validPermissions = Permission::whereIn('id', $permissionIds)->get();
        foreach ($validPermissions as $validPermission) {
            /** @var Permission $validPermission */
            OrganizationPermission::updateOrCreate(
                [
                    'organization_id' => $organizationId,
                    'permission_id' => $validPermission->id
                ],
                [
                    'organization_id' => $organizationId,
                    'permission_id' => $validPermission->id
                ]
            );
        }
        return $validPermissions->toArray();
    }

    /**
     * @param int $instituteId
     * @param array $permissionIds
     * @return array
     */
    public function setPermissionToInstitute(int $instituteId, array $permissionIds): array
    {
        /** @var Permission $validPermissions */
        $validPermissions = Permission::whereIn('id', $permissionIds)->get();
        foreach ($validPermissions as $validPermission) {
            /** @var Permission $validPermission */
            InstitutePermission::updateOrCreate(
                [
                    'institute_id' => $instituteId,
                    'permission_id' => $validPermission->id
                ],
                ['institute_id' => $instituteId,
                    'permission_id' => $validPermission->id
                ]
            );
        }
        return $validPermissions->toArray();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        $rules = [
            'title' => 'required|string|max:500|min:2',
            'title_en' => 'required|string|max:191|min:2',
            'method' => 'required|int',
            'module' => 'required|max:191|string',
            'key' => [
                'required',
                'unique:permissions,key,' . $id
            ],
            'uri' => [
                'required',
                'unique_with:permissions,method,' . $id,
                'max:300',
                'min:2'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];

        return Validator::make($request->all(), $rules, $customMessage);
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
            'page' => 'int|gt:0',
            'page_size' => 'int|gt:0',
            'key' => 'nullable|max:191|min:2',
            'uri' => 'nullable|max:300|min:2',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "nullable",
                "int",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

}
