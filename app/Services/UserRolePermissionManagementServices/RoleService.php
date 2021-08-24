<?php

namespace App\Services\UserRolePermissionManagementServices;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleService
{
    const ROUTE_PREFIX = 'api.v1.roles.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllRoles(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
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
        ]);
        $roles->leftJoin('permission_groups', 'permission_groups.id', 'roles.permission_group_id');
        $roles->orderBy('roles.id', $order);

        if (!empty($titleEn)) {
            $roles->where('roles.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $roles->where('roles.title_bn', 'like', '%' . $titleBn . '%');
        }

        if ($paginate) {
            $roles = $roles->paginate(10);
            $paginateData = (object)$roles->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $roles = $roles->get();
        }

        $data = [];
        foreach ($roles as $role) {
            $links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $role->id]);
            $links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $role->id]);
            $links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $role->id]);
            $role['_links'] = $links;
            $data[] = $role->toArray();
        }

        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
               "query_time" =>$startTime->diffInSeconds(Carbon::now()),
            ],
            "_links" => [
                'paginate' => $paginateLink,
                'search' => [
                    'parameters' => [
                        'title_en',
                        'title_bn'
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
    public function getOneRole(int $id, Carbon $startTime): array
    {
        $startTime = Carbon::now();
        $links = [];

        /** @var Role|Builder $role */
        $role = Role::select([
            'roles.id',
            'roles.title_bn',
            'roles.title_en',
            'roles.key',
            'roles.description',
            'roles.permission_group_id',
            'roles.organization_id',
            'roles.institute_id'
        ]);
        $role->where('id', $id);
        $role = $role->first();

        if (!empty($role)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $role->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $role->id])
            ];
        }

        return [
            "data" => $role ? $role : null,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
               "query_time" =>$startTime->diffInSeconds(Carbon::now()),
            ],
            "_links" => $links
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
        $rules = [];
        if (!isset($request->permissions) && isset($request->title_en) && isset($request->title_bn) && isset($request->key)) {
            $rules = [
                'title_en' => 'required|min:2',
                'title_bn' => 'required|min:2',
                'description' => 'nullable',
                'permission_group_id' => 'nullable|exists:permission_groups,id',
                'organization_id' => 'nullable|numeric',
                'institute_id' => 'nullable|numeric',
            ];
            if (!empty($id)) {
                $rules['key'] = 'required|min:2|unique:roles,key,' . $id;
            } else {
                $rules['key'] = 'required|min:2|unique:roles,key';
            }
        } elseif (isset($request->permissions) && !isset($request->title_en) && !isset($request->title_bn) && !isset($request->key)) {
            $rules = [
                'permissions' => 'required|array|min:1',
                'permissions.*' => 'required|numeric|distinct|min:1'
            ];
        }
        return Validator::make($request->all(), $rules);
    }
}
