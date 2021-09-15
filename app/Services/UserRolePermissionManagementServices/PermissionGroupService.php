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
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissionGroups(array $request, Carbon $startTime): array
    {
        $paginate = array_key_exists('page', $request) ? $request['page'] : "";
        $limit = array_key_exists('limit', $request) ? $request['limit'] : "";
        $titleEn = array_key_exists('title_en', $request) ? $request['title_en'] : "";
        $titleBn = array_key_exists('title_bn', $request) ? $request['title_bn'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

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

        if (is_numeric($rowStatus)) {
            $permissionGroupBuilder->where('row_status', $rowStatus);
        }

        /** @var Collection|PermissionGroup $permissionGroups */
        if (is_numeric($paginate) || is_numeric($limit)) {
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
    public function getOnePermissionGroup(Request $request, int $id, Carbon $startTime): array
    {
        $permissionSubGroup = $request->query('permission_sub_group', 0);
        $permission = $request->query('permission', 0);

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

        if($permissionSubGroup==1){
            $permissionGroupBuilder->with('permissionSubGroup');
        }

        if($permission==1){
            $permissionGroupBuilder->with('permissions');
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
        $permissionGroup->permissions()->sync($validPermissions);
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

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC',
            'row_status.in' => 'Row status must be within 1 or 0'
        ];

        return Validator::make($request->all(), [
            'title_en' => 'nullable|min:1',
            'title_bn' => 'nullable|min:1',
            'page' => 'numeric',
            'limit' => 'numeric',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

}
