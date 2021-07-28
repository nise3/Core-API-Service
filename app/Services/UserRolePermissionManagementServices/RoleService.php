<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleService
{
    const ROUTE_PREFIX = 'api.v1.roles.';

    /**
     * @param Request $request
     * @return array
     */
    public function getAllRoles(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $startTime = Carbon::now();

        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Role|Builder $role */
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
            $paginate_data = (object)$roles->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $roles = $roles->get();
        }


        $data = [];
        foreach ($roles as $role) {
            $_links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $role->id]);
            $_links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $role->id]);
            $_links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $role->id]);
            $role['_links'] = $_links;
            $data[] = $role->toArray();

        }

        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
                'search' => [
                    'parameters' => [
                        'title_en',
                        'title_bn'
                    ],
                    '_link' => route(self::ROUTE_PREFIX .'get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function getOneRole($id): array
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
        ])->where('id', $id)->first();;

        if (!empty($role)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $role->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $role->id])
            ];
        }

        return [
            "data" => $role ? $role : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
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
     * @return Role
     */
    public function destroy(Role $role): Role
    {
        $role->row_status = 99;
        $role->save();

        return $role;
    }

    /**
     * @param Role $role
     * @param array $permission_ids
     * @return Role
     */
    public function assignPermission(Role $role, array $permission_ids):Role
    {
        $validPermissions=Permission::whereIn('id',$permission_ids)->orderBy('id','ASC')->pluck('id')->toArray();
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
