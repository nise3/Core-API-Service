<?php


namespace App\Services\UserRolePermissionManagementServices;


use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PermissionGroupService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllPermissionGroups(array $request, Carbon $startTime): array
    {
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $key = $request['key'] ?? null;

        /** @var PermissionGroup|Builder $permissionGroupBuilder */
        $permissionGroupBuilder = PermissionGroup::select([
            'permission_groups.id',
            'permission_groups.title_en',
            'permission_groups.title',
            'permission_groups.key',
            "permission_groups.row_status",
            "permission_groups.created_at",
            "permission_groups.updated_at"
        ]);

        $permissionGroupBuilder->orderBy('id', $order);

        if (!empty($titleEn)) {
            $permissionGroupBuilder->where('title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $permissionGroupBuilder->where('title', 'like', '%' . $title . '%');
        }

        if (is_numeric($rowStatus)) {
            $permissionGroupBuilder->where('row_status', $rowStatus);
        }

        if (!empty($key)) {
            $permissionGroupBuilder->where('permission_groups.key', $key);
        }

        /** @var Collection|PermissionGroup $permissionGroups */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $permissionGroups = $permissionGroupBuilder->paginate($pageSize);
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
     * @param Request $request
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
            'permission_groups.id',
            'permission_groups.title_en',
            'permission_groups.title',
            'permission_groups.key',
            "permission_groups.row_status",
            "permission_groups.created_at",
            "permission_groups.updated_at"
        ]);

        $permissionGroupBuilder->where('id', $id);


        if ($permissionSubGroup == BaseModel::WITH_PERMISSION_SUB_GROUP_TRUE) {
            $permissionGroupBuilder->with('permissionSubGroup');
        }

        if ($permission == BaseModel::WITH_PERMISSION_TRUE) {
            $permissionGroupBuilder->with('permissions');
        }


        /** @var PermissionGroup $permissionGroup */
        $permissionGroup = $permissionGroupBuilder->firstOrFail();

        return [
            "data" => $permissionGroup,
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
        $permissionGroup->fill($data);
        $permissionGroup->save();
        return $permissionGroup;
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
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
        $rules = [
            'title_en' => 'nullable|max:191|min:2',
            'title' => 'required|max:300|min:2',
            "key" => ['required', 'max:191', 'min:2', 'unique:permission_groups,key,' . $id],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

    public function permissionValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $permissions = $request->input('permissions');
        $data = [];

        if ($permissions) {
            $data = [
                'permissions' => is_array($permissions) ? $permissions : explode(',', $permissions)
            ];
        }

        $rules = [
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|int|distinct|min:1'
        ];
        return Validator::make($data, $rules);
    }

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0.[30000]'
        ];

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:191|min:2',
            'title' => 'nullable|max:300|min:2',
            'page' => 'int|gt:0',
            'page_size' => 'int|gt:0',
            'key' => 'nullable|max:191|string',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "int",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

}
