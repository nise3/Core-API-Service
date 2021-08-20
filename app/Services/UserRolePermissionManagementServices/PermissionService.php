<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\InstitutePermissions;
use App\Models\OrganizationPermissions;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\HttpFoundation\Response;

class PermissionService
{
    const ROUTE_PREFIX = 'api.v1.permissions.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissions(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $paginate = $request->query('page');
        $searchFilter = $request->query('name');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var Permission|Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'id',
            'name',
            'uri'
        ]);

        $permissionBuilder->orderBy('id', $order);

        if (!empty($searchFilter)) {
            $permissionBuilder->where('name', 'like', '%' . $searchFilter . '%');
        }

        if (!empty($paginate)) {
            /** @var Collection|Permission $permissions */
            $permissions = $permissionBuilder->paginate(10);
            $paginateData = (object)$permissions->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $permissions = $permissionBuilder->get();
        }

        $data = [];
        foreach ($permissions as $permission) {
            /** @var  Permission $permission */
            $links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $permission->id]);
            $links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $permission->id]);
            $links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission->id]);
            $permission['_links'] = $links;
            $data[] = $permission->toArray();
        }

        return [
            "data" => $data ?: null,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
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
    public function getOnePermission(int $id, Carbon $startTime): array
    {
        /** @var Permission|Builder $permissionBuilder */
        $permissionBuilder = Permission::select([
            'id',
            'name',
            'uri'
        ]);
        $permissionBuilder->where('id', $id);

        $permission = $permissionBuilder->first();

        $links = [];
        if (!empty($permission)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $permission->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission->id])
            ];
        }

        return [
            "data" => $permission ?: null,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ],
            "_links" => $links
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
        ];
        if (!empty($id)) {
            $rules['uri'] = 'required|min:2|unique:permissions,uri,' . $id;
        } else {
            $rules['uri'] = 'required|min:2|unique:permissions,uri';
        }
        return Validator::make($request->all(), $rules);
    }

    public function permissionValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|numeric|distinct|min:1'
        ];
        return Validator::make($request->all(), $rules);
    }


}
