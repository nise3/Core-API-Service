<?php


namespace App\Services\UserRolePermissionManagementServices;


use App\Models\Permission;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionGroupService
{
    const ROUTE_PREFIX = 'api.v1.permission-groups.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissionGroups(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $paginate = $request->query('page');
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var PermissionGroup|Builder $permissionGroups */
        $permissionGroups = PermissionGroup::select([
            'id',
            'title_en',
            'title_bn',
            'key'
        ]);

        if (!empty($titleEn)) {
            $permissionGroups = $permissionGroups->where('title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $permissionGroups = $permissionGroups->where('title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!empty($paginate)) {
            $permissionGroups = $permissionGroups->paginate(10);
            $paginateData = (object)$permissionGroups->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $permissionGroups = $permissionGroups->get();
        }

        $data = [];
        foreach ($permissionGroups as $permission) {
            $links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $permission->id]);
            $links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $permission->id]);
            $links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission->id]);
            $permission['_links'] = $links;
            $data[] = $permission->toArray();
        }

        return [
            "data" => $data,
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
    public function getOnePermissionGroup(int $id, Carbon $startTime): array
    {
        /** @var PermissionGroup|Builder $permissionGroup */
        $permissionGroup = PermissionGroup::select([
            'id',
            'title_en',
            'title_bn',
            'key'
        ]);
        $permissionGroup->where('id', $id);
        $permissionGroup = $permissionGroup->first();

        $links = [];
        if (!empty($permissionGroup)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $permissionGroup->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $permissionGroup->id])
            ];
        }

        return [
            "data" => $permissionGroup ?: null,
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
     * @return bool
     */
    public function destroy(PermissionGroup $permissionGroup): bool
    {
        return $permissionGroup->delete();
    }

    public function assignPermission(PermissionGroup $permissionGroup,array $permission_ids):PermissionGroup
    {
        $validPermissions=Permission::whereIn('id',$permission_ids)->orderBy('id','ASC')->pluck('id')->toArray();
        $permissionGroup->permissions()->syncWithoutDetaching($validPermissions);
        return $permissionGroup;
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
            ];
            if (!empty($id)) {
                $rules['key'] = 'required|min:2|unique:permission_groups,key,' . $id;
            } else {
                $rules['key'] = 'required|min:2|unique:permission_groups,key';
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
