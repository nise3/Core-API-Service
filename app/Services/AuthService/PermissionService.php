<?php


namespace App\Services\AuthService;


use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class PermissionService
{

    /**
     * @var Carbon
     */
    public Carbon $startTime;

    const ROUTE_PREFIX = 'api.v1.permissions.';

    /**
     * PermissionService constructor.
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
    public function getAllPermissions(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $paginate = $request->query('page');
        $search_filter = $request->query('name');
        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        $permissions = Permission::select([
            'id',
            'name',
            'key'
        ]);

        if (!empty($search_filter)) {
            $permissions = $permissions->where('name', 'like', '%' . $search_filter . '%');
        }
        if (!empty($paginate)) {
            $permissions = $permissions->paginate(10);
            $paginate_data = (object)$permissions->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $permissions = $permissions->get();
        }
        $data = [];
        foreach ($permissions as $permission) {
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
    public function getOnePermission(Request $request, $id): array
    {
        $permission = Permission::select([
            'id',
            'name',
            'key'
        ])->where('id', $id)->first();

        $links = [];
        if (!empty($permission)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $permission->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $permission->id])
            ];
        }
        return [
            "data" => $permission ? $permission : [],
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
     * @param Permission $permission
     * @return Permission
     */
    public function store(array $data, Permission $permission): Permission
    {
        return $permission->create($data);

    }

    /**
     * @param array $data
     * @param Permission $permission
     * @return bool
     */
    public function update(array $data, Permission $permission):Permission
    {
        $permission->fill($data);
        $permission->save($data);
        return $permission;
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function destroy(Permission $permission):Permission
    {
        $permission->delete();
        return $permission;
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
            $rules['key'] = 'required|min:2|unique:permissions,key,' . $id;
        } else {
            $rules['key'] = 'required|min:2|unique:permissions,key';
        }

        return Validator::make($request->all(), $rules);
    }

}
