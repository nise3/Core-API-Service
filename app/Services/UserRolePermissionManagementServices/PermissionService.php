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

class PermissionService
{

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissions(Request $request, Carbon $startTime): array
    {
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $searchFilter = $request->query('name');
        $rowStatus = $request->query('row_status');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var Permission|Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'id',
            'name',
            'uri',
            'method',
            'row_status',
            'created_at',
            'updated_at'
        ]);

        $permissionBuilder->orderBy('id', $order);

        if (!empty($searchFilter)) {
            $permissionBuilder->where('name', 'like', '%' . $searchFilter . '%');
        }

        if (!is_null($rowStatus)) {
            $permissionBuilder->where('permissions.row_status', $rowStatus);
        }

        if (!is_null($paginate) || !is_null($limit)) {
            $limit = $limit ?: 10;
            /** @var Collection|Permission $permissions */
            $permissions = $permissionBuilder->paginate($limit);
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
            'id',
            'name',
            'uri',
            'method',
            'row_status',
            'created_at',
            'updated_at'
        ]);

        if (!empty($id)) {
            $permissionBuilder->where('id', $id);
        }

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
        return $permission->create($data);
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
        $rules = [
            'name' => 'required|min:2',
            'method' => 'required|numeric',
            'uri' => 'required|min:2|unique:permissions,uri,' . $id,
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
