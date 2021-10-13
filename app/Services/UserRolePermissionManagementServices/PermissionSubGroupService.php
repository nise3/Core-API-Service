<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\PermissionSubGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PermissionSubGroupService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissionSubGroups(array $request, Carbon $startTime): array
    {

        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $permissionGroupId = $request['permission_group_id'] ?? "";


        /** @var PermissionSubGroup|Builder $permissionSubGroupBuilder */
        $permissionSubGroupBuilder = PermissionSubGroup::select([
            'permission_sub_groups.id',
            'permission_sub_groups.title_en',
            'permission_sub_groups.title',
            'permission_sub_groups.key',
            'permission_sub_groups.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title as permission_group_title',
            'permission_sub_groups.row_status',
            "permission_sub_groups.created_at",
            "permission_sub_groups.updated_at"
        ]);
        $permissionSubGroupBuilder->join('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');

        if (!empty($titleEn)) {
            $permissionSubGroupBuilder->where('permission_sub_groups.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($title)) {
            $permissionSubGroupBuilder->where('permission_sub_groups.title', 'like', '%' . $title . '%');
        }

        if (is_numeric($rowStatus)) {
            $permissionSubGroupBuilder->where('permission_sub_groups.row_status', $rowStatus);
        }

        if (is_numeric($permissionGroupId)) {
            $permissionSubGroupBuilder->where('permission_sub_groups.permission_group_id', $permissionGroupId);
        }

        $permissionSubGroupBuilder->orderBy('permission_sub_groups.id', $order);

        /** @var Collection|PermissionSubGroup $permissionSubGroups */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $permissionSubGroups = $permissionSubGroupBuilder->paginate($pageSize);
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
            'permission_sub_groups.id',
            'permission_sub_groups.title_en',
            'permission_sub_groups.title',
            'permission_sub_groups.key',
            'permission_sub_groups.permission_group_id',
            'permission_groups.title_en as permission_group_title_en',
            'permission_groups.title as permission_group_title',
            'permission_sub_groups.row_status',
            "permission_sub_groups.created_at",
            "permission_sub_groups.updated_at"
        ]);
        $permissionSubGroupBuilder->join('permission_groups', 'permission_groups.id', 'permission_sub_groups.permission_group_id');
        $permissionSubGroupBuilder->where('permission_sub_groups.id', $id);

        $permissionSubGroupBuilder->with('permissions');

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
        $permissionSubGroup->fill($data);
        $permissionSubGroup->save();
        return $permissionSubGroup;
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

        $validPermissions = DB::table('permission_group_permissions')
            ->where('permission_group_id', $permissionSubGroup->permission_group_id ?? null)
            ->whereIn('permission_id', $permissionIds)
            ->orderBy('permission_id', 'ASC')
            ->pluck('permission_id')
            ->toArray();
        $permissionSubGroup->permissions()->sync($validPermissions);
        return $permissionSubGroup;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'permission_group_id' => 'required|int|exists:permission_groups,id',
            'title_en' => 'required|string|max:191||min:2',
            'title' => 'required|string|max:300|min:2',
            "key" => 'required|string|max:191|min:2|unique:permission_sub_groups,key,' . $id,
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
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
            'permissions.*' => 'required|integer|distinct|min:1'
        ];
        return Validator::make($data, $rules);
    }

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        return Validator::make($request->all(), [
            'page' => 'inte|gt:0',
            'page_size' => 'inte|gt:0',
            'title_en' => 'nullable|max:191|min:2',
            'title' => 'nullable|max:300|min:2',
            'permission_group_id' => 'nullable|inte|exists:permission_groups,id',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "inte",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

}
