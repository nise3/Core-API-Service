<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\Permission;
use App\Models\PermissionSubGroup;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionSubGroupService
{
    const ROUTE_PREFIX = 'api.v1.permission-sub-groups.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissionSubGroups(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $paginate = $request->query('page');
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var PermissionSubGroup|Builder $permissionSubGroups */
        $permissionSubGroups = PermissionSubGroup::select([
            'permission_sub_groups.id',
            'permission_sub_groups.permission_group_id',
            'permission_sub_groups.title_en',
            'permission_sub_groups.title_bn',
            'permission_sub_groups.key',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
        ]);
        $permissionSubGroups->join('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');

        if (!empty($titleEn)) {
            $permissionSubGroups = $permissionSubGroups->where('permission_sub_groups.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($titleBn)) {
            $permissionSubGroups = $permissionSubGroups->where('permission_sub_groups.title_bn', 'like', '%' . $titleBn . '%');
        }

        $permissionSubGroups->orderBy('permission_sub_groups.id', $order);

        if (!empty($paginate)) {
            $permissionSubGroups = $permissionSubGroups->paginate(10);
            $paginateData = (object)$permissionSubGroups->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $permissionSubGroups = $permissionSubGroups->get();
        }

        $data = [];
        foreach ($permissionSubGroups as $permission) {
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
                "code" => JsonResponse::HTTP_OK,
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
    public function getOnePermissionSubGroup(int $id, Carbon $startTime): array
    {
        /** @var PermissionSubGroup|Builder $permissionSubGroup */
        $permissionSubGroup = PermissionSubGroup::select([
            'permission_sub_groups.id',
            'permission_sub_groups.permission_group_id',
            'permission_sub_groups.title_en',
            'permission_sub_groups.title_bn',
            'permission_sub_groups.key',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
        ]);
        $permissionSubGroup->join('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');
        $permissionSubGroup->where('permission_sub_groups.id', $id);
        $permissionSubGroup = $permissionSubGroup->first();

        $links = [];
        if (!empty($permissionSubGroup)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $permissionSubGroup->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $permissionSubGroup->id])
            ];
        }
        return [
            "data" => $permissionSubGroup ?: null,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
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
     * @return bool
     */
    public function destroy(PermissionSubGroup $permissionSubGroup): bool
    {
        return $permissionSubGroup->delete();
    }

    public function assignPermission(PermissionSubGroup $permissionSubGroup, array $permissionIds): PermissionSubGroup
    {
        $validPermissions = Permission::whereIn('id', $permissionIds)->orderBy('id', 'ASC')->pluck('id')->toArray();
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
                'permission_group_id' => 'required|numeric|exists:permission_groups,id',
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
