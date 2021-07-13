<?php


namespace App\Services\UserRolePermissionManagementServices;


use App\Models\Permission;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionGroupService
{
    public Carbon $startTime;
    const ROUTE_PREFIX = 'api.v1.permission-groups.';

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
    public function getAllPermissionGroups(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $paginate = $request->query('page');
        $search_filter = $request->query('name');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        $permission_groups = PermissionGroup::select([
            'id',
            'name',
            'key'
        ]);

        if (!empty($search_filter)) {
            $permission_groups = $permission_groups->where('name', 'like', '%' . $search_filter . '%');
        }
        if (!empty($paginate)) {
            $permission_groups = $permission_groups->paginate(10);
            $paginate_data = (object)$permission_groups->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $permission_groups = $permission_groups->get();
        }
        $data = [];
        foreach ($permission_groups as $permission) {
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
    public function getOnePermissionGroup(Request $request, $id): array
    {
        $permission_group = PermissionGroup::select([
            'id',
            'name',
            'key'
        ])->where('id', $id)->first();

        $links = [];

        if (!empty($permission_group)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $permission_group->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission_group->id])
            ];
        }
        return [
            "data" => $permission_group ? $permission_group : [],
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
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function store(array $data, PermissionGroup $permissionGroup): PermissionGroup
    {
        return $permissionGroup->create($data);
    }


    /**
     * @param array $data
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function update(array $data, PermissionGroup $permissionGroup): PermissionGroup
    {
        $permissionGroup->fill($data);
        $permissionGroup->save();
        return $permissionGroup;
    }

    /**
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function destroy(PermissionGroup $permissionGroup): PermissionGroup
    {
        $permissionGroup->delete();
        return $permissionGroup;
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
        ];
        if (!empty($id)) {
            $rules['key'] = 'required|min:2|unique:permission_groups,key,' . $id;
        } else {
            $rules['key'] = 'required|min:2|unique:permission_groups,key';
        }

        return Validator::make($request->all(), $rules);
    }

}
