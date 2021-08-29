<?php


namespace App\Services\UserRolePermissionManagementServices;


use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $rowStatus = $request->query('row_status');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        /** @var PermissionGroup|Builder $permissionGroupBuilder */
        $permissionGroupBuilder = PermissionGroup::select([
            'id',
            'title_en',
            'title_bn',
            'key',
            "row_status",
            "created_at",
            "updated_at"
        ]);

        $permissionGroupBuilder->orderBy('id', $order);

        if (!empty($titleEn)) {
            $permissionGroupBuilder->where('title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $permissionGroupBuilder->where('title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!is_null($rowStatus)) {
            $permissionGroupBuilder->where('row_status', $rowStatus);
        }

        /** @var Collection|PermissionGroup $permissionGroups */
        if (!is_null($paginate) || !is_null($limit)) {
            $limit = $limit ?: 10;
            $permissionGroups = $permissionGroupBuilder->paginate($limit);
            $paginateData = (object)$permissionGroups->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $permissionGroups = $permissionGroupBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $permissionGroups->toArray()['data'] ?? $permissionGroups->toArray();
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
    public function getOnePermissionGroup(int $id, Carbon $startTime): array
    {
        /** @var PermissionGroup|Builder $permissionGroupBuilder */
        $permissionGroupBuilder = PermissionGroup::select([
            'id',
            'title_en',
            'title_bn',
            'key',
            "row_status",
            "created_at",
            "updated_at"
        ]);

        if (!empty($id)) {
            $permissionGroupBuilder->where('id', $id);
        }

        /** @var PermissionGroup $permissionGroup */
        $permissionGroup = $permissionGroupBuilder->first();
        return [
            "data" => $permissionGroup ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
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

    public function assignPermission(PermissionGroup $permissionGroup, array $permission_ids): PermissionGroup
    {
        /** @var Collection|Permission $validPermissions */
        $validPermissions = Permission::whereIn('id', $permission_ids)->orderBy('id', 'ASC')->pluck('id')->toArray();
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
        $rules = [
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            "key" => 'required|min:2|unique:permission_groups,key,' . $id,
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
