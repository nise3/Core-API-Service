<?php


namespace App\Services\AuthService;


use App\Models\Permission;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Http\JsonResponse;

class PermissionService
{
    public Carbon $startTime;
    const ROUTE_PREFIX='api.v1.permissions.';

    /**
     * PermissionService constructor.
     * @param Carbon $startTime
     */
    public function __construct(Carbon $startTime)
    {
        $this->startTime = $startTime;
    }


    public function getAllPermissions(Request $request):array
    {
        $paginate_link = [];
        $page = [];
        $paginate=$request->getQuery('page');
        $search_filter=$request->getQuery('name');
        $order=!empty($request->getQuery('order'))?$request->getQuery('order'):"ASC";

        $permissions=Permission::select([
            'id',
            'name',
            'key'
        ]);

        if(!empty($search_filter)){
            $permissions=$permissions->where('name','like','%'.$search_filter.'%');
        }
        if(!empty($paginate)){
            $permissions=$permissions->paginate(10);
            $paginate_data=(object)$permissions->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        }else{
            $permissions=$permissions->get();
        }
        $data = [];
        foreach ($permissions as $permission) {
            $_links['read'] = route(self::ROUTE_PREFIX.'.read', ['id' => $permission->id]);
            $_links['update'] = route(self::ROUTE_PREFIX.'update', ['id' => $permission->id]);
            $_links['delete'] = route(self::ROUTE_PREFIX.'destroy', ['id' => $permission->id]);
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
                        'title_en',
                        'title_bn'
                    ],
                    '_link' => route('api.v1.districts.get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];

    }

    public function getOnePermission(Request $request,$id):array
    {
        $permission=Permission::findOrFail($id);
        $links=[];
        if(!empty($permission)){
            $links = [
                'update' => route('api.v1.districts.update', ['id' => $district->id]),
                'delete' => route('api.v1.districts.destroy', ['id' => $district->id])
            ];
        }
        return [
            "data" => $district ? $district : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
    }


}
