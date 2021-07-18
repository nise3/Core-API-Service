<?php


namespace App\Services\UserRolePermissionManagementServices;


use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionSubGroupService
{
    public Carbon $startTime;
    const ROUTE_PREFIX = 'api.v1.permission-sub-groups.';

    /**
     * PermissionGroupService constructor.
     * @param Carbon $startTime
     */
    public function __construct(Carbon $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllPermissionSubGroups(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $paginate = $request->query('page');
        $title_en = $request->query('title_en');
        $title_bn = $request->query('title_bn');

        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        $permission_sub_groups = PermissionSubGroup::select([
            'permission_sub_groups.id',
            'permission_sub_groups.permission_group_id',
            'permission_sub_groups.title_en',
            'permission_sub_groups.title_bn',
            'permission_sub_groups.key',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',

        ]);

        $permission_sub_groups->leftJoin('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');

        if (!empty($title_en)) {
            $permission_sub_groups = $permission_sub_groups->where('permission_sub_groups.title_en', 'like', '%' . $title_en . '%');
        }
        if (!empty($title_bn)) {
            $permission_sub_groups = $permission_sub_groups->where('permission_sub_groups.title_bn', 'like', '%' . $title_bn . '%');
        }
        $permission_sub_groups->orderBy('permission_sub_groups.id',$order);

        if (!empty($paginate)) {
            $permission_sub_groups = $permission_sub_groups->paginate(10);
            $paginate_data = (object)$permission_sub_groups->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $permission_sub_groups = $permission_sub_groups->get();
        }
        $data = [];
        foreach ($permission_sub_groups as $permission) {
            $_links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $permission->id]);
            $_links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $permission->id]);
            $_links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission->id]);
            $permission['_links'] = $_links;
            $data[] = $permission->toArray();

        }
        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
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
     * @param Request $request
     * @param $id
     * @return array
     */
    public function getOnePermissionSubGroup(Request $request, $id): array
    {

        $permission_sub_group = PermissionSubGroup::select([
            'permission_sub_groups.id',
            'permission_sub_groups.permission_group_id',
            'permission_sub_groups.title_en',
            'permission_sub_groups.title_bn',
            'permission_sub_groups.key',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
        ])->where('permission_sub_groups.id', $id);

        $permission_sub_group->leftJoin('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');

        $permission_sub_group=$permission_sub_group->first();

        $links = [];

        if (!empty($permission_sub_group)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $permission_sub_group->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission_sub_group->id])
            ];
        }
        return [
            "data" => $permission_sub_group ? $permission_sub_group : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
    }

    /**
     * @param array $data
     * @param PermissionSubGroup $permissionSubGroup
     * @return PermissionSubGroup
     */
    public function store(array $data, PermissionSubGroup $permissionSubGroup): PermissionSubGroup
    {
        return $permissionSubGroup->create($data);
    }


    /**
     * @param array $data
     * @param PermissionSubGroup $permissionSubGroup
     * @return PermissionSubGroup
     */
    public function update(array $data, PermissionSubGroup $permissionSubGroup): PermissionSubGroup
    {
        $permissionSubGroup->fill($data);
        $permissionSubGroup->save();
        return $permissionSubGroup;
    }

    /**
     * @param PermissionSubGroup $permissionSubGroup
     * @return PermissionSubGroup
     */
    public function destroy(PermissionSubGroup $permissionSubGroup): PermissionSubGroup
    {
        $permissionSubGroup->delete();
        return $permissionSubGroup;
    }

    public function assignPermission(PermissionSubGroup $permissionSubGroup,array $permission_ids):PermissionSubGroup
    {
        $validPermissions=Permission::whereIn('id',$permission_ids)->orderBy('id','ASC')->pluck('id')->toArray();
        $permissionSubGroup->permissions()->syncWithoutDetaching($validPermissions);
        return $permissionSubGroup;
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
                'permission_group_id' => 'required|numeric|exists:permission_groups,id', //TODO: always check if foreign key data exists in table.
                'title_en' => 'required|min:2',
                'title_bn' => 'required|min:2',
            ];
            if (!empty($id)) {
                $rules['key'] = 'required|min:2|unique:permission_sub_groups,key,' . $id;
            } else {
                $rules['key'] = 'required|min:2|unique:permission_sub_groups,key';
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
