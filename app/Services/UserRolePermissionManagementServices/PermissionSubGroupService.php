<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\PermissionSubGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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

        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $order = $request->query('order', "ASC");

        /** @var PermissionSubGroup|Builder $permissionSubGroupBuilder */
        $permissionSubGroupBuilder = PermissionSubGroup::select([
            'permission_sub_groups.*',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
        ]);
        $permissionSubGroupBuilder->join('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');

        if (!empty($titleEn)) {
            $permissionSubGroupBuilder->where('permission_sub_groups.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($titleBn)) {
            $permissionSubGroupBuilder->where('permission_sub_groups.title_bn', 'like', '%' . $titleBn . '%');
        }

        $permissionSubGroupBuilder->orderBy('permission_sub_groups.id', $order);

        /** @var Collection|PermissionSubGroup $permissionSubGroups */
        if ($paginate || $limit) {
            $limit = $limit ?: 10;
            $permissionSubGroups = $permissionSubGroupBuilder->paginate($limit);
            $paginateData = (object)$permissionSubGroups->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $permissionSubGroups = $permissionSubGroupBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $permissionSubGroups->toArray()['data'] ?? $permissionSubGroups->toArray();
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
    public function getOnePermissionSubGroup(int $id, Carbon $startTime): array
    {
        /** @var PermissionSubGroup|Builder $permissionSubGroupBuilder */
        $permissionSubGroupBuilder = PermissionSubGroup::select([
            'permission_sub_groups.*',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title_bn as permission_group_title_bn',
        ]);
        $permissionSubGroupBuilder->join('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');
        $permissionSubGroupBuilder->where('permission_sub_groups.id', $id);

        /** @var PermissionSubGroup $permissionSubGroup */
        $permissionSubGroup = $permissionSubGroupBuilder->first();

        return [
            "data" => $permissionSubGroup ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ]
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
        $rules = [
            'permission_group_id' => 'required|numeric|exists:permission_groups,id',
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            "key" => 'required|min:2|unique:permission_sub_groups,key,' . $id,
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules);
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

}
