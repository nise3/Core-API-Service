<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\InstitutePermissions;
use App\Models\OrganizationPermissions;
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
        $name = $request['name'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $uri = $request['uri'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Permission|Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'permissions.id',
            'permissions.module',
            'permissions.name',
            'permissions.uri',
            'permissions.method',
            'permissions.row_status',
            'permissions.created_at',
            'permissions.updated_at'
        ]);

        $permissionBuilder->orderBy('id', $order);

        if (!empty($name)) {
            $permissionBuilder->where('name', 'like', '%' . $name . '%');
        }

        if (!empty($uri)) {
            $permissionBuilder->where('uri', 'like', '%' . $uri . '%');
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
        /** @var Permission|Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'permissions.id',
            'permissions.name',
            'permissions.module',
            'permissions.uri',
            'permissions.method',
            'permissions.row_status',
            'permissions.created_at',
            'permissions.updated_at'
        ]);


        $permissionBuilder->where('id', $id);


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
     * @param array $data
     * @param Permission $permission
     * @return Permission
     */
    public function store(array $data, Permission $permission): Permission
    {
        $permission->fill($data);
        $permission->save($data);
        return $permission;
    }

    /**
     * @param array $data
     * @param Permission $permission
     * @return Permission
     */
    public function update(array $data, Permission $permission): Permission
    {
        $permission->fill($data);
        $permission->save($data);
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
        $methodName = "";
        switch ($item) {
            case 1:
                $methodName = "GET";
                break;
            case 2:
                $methodName = "POST";
                break;
            case 3:
                $methodName = "PUT";
                break;
            case 4:
                $methodName = "PATCH";
                break;
            case 5:
                $methodName = "DELETE";
                break;

        }
        return $methodName;
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
            OrganizationPermissions::updateOrCreate(
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
            InstitutePermissions::updateOrCreate(
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
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'name' => 'required|string|max:191|min:2',
            'method' => 'required|numeric',
            'module' => 'required|max:191|string',
            'uri' => 'required|max:300|min:2|unique:permissions,uri,' . $id,
            'row_status' => [
                'required_if:' . $id . ',!=,null',
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

        $data["permissions"] = is_array($request['permissions']) ? $request['permissions'] : explode(',', $request['permissions']);

        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|numeric|distinct|min:1'
        ];
        return Validator::make($data, $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
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
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric|gt:0',
            'name' => 'max:191|min:2',
            'uri' => 'max:300|min:2',
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
