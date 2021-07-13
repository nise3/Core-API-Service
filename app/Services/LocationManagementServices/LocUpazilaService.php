<?php


namespace App\Services\LocationManagementServices;


use App\Models\LocUpazila;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;


class LocUpazilaService
{
    public Carbon $startTime;
    const ROUTE_PREFIX = 'api.v1.upazilas.';


    /**
     * LocUpazilaService constructor.
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
    public function getAllUpazilas(Request $request): array
    {
        $paginate_link = [];
        $page = [];

        $paginate = $request->query('page');
        $district_id = $request->query('district_id');
        $division_id = $request->query('division_id');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var LocUpazila|Builder $upazilas */
        $upazilas = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.loc_district_id',
            'loc_upazilas.loc_division_id',
            'loc_upazilas.title_bn',
            'loc_upazilas.title_en',
            'loc_districts.title_bn as district_title_bn',
            'loc_districts.title_en as district_title_en',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ])->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
            ->leftJoin('loc_districts', 'loc_districts.id', '=', 'loc_upazilas.loc_division_id');

        $upazilas->orderBy('loc_upazilas.id', $order);
        $upazilas->where('loc_districts.row_status', LocUpazila::ROW_STATUS_ACTIVE);
        if (!empty($request->query('title_en'))) {
            $upazilas->where('loc_upazilas.title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $upazilas->where('loc_upazilas.title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }

        if (!empty($district_id)) {
            $upazilas->where('loc_upazilas.loc_district_id', $district_id);
        }

        if (!empty($division_id)) {
            $upazilas->where('loc_upazilas.loc_division_id', $division_id);
        }

        if (!empty($paginate)) {
            $upazilas = $upazilas->paginate(10);
            $paginate_data = (object)$upazilas->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $upazilas = $upazilas->get();
        }

        $data = [];
        foreach ($upazilas as $upazila) {
            $_links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $upazila->id]);
            $_links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $upazila->id]);
            $_links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $upazila->id]);
            $upazila['_links'] = $_links;
            $data[] = $upazila->toArray();

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
                    '_link' => route(self::ROUTE_PREFIX . 'get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];

    }

    /**
     * @param int $id
     * @return array
     */
    public function getOneUpazila(int $id): array
    {

        $links = [];

        $upazila = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.loc_district_id',
            'loc_upazilas.loc_division_id',
            'loc_upazilas.title_bn',
            'loc_upazilas.title_en',
            'loc_districts.title_bn as district_title_bn',
            'loc_districts.title_en as district_title_en',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ])->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
            ->leftJoin('loc_districts', 'loc_districts.id', '=', 'loc_upazilas.loc_division_id')
            ->where('loc_upazilas.row_status', LocUpazila::ROW_STATUS_ACTIVE)
            ->where('loc_upazilas.id', $id)->first();



        if (!empty($upazila)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $upazila->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $upazila->id])
            ];
        }

        $response = [
            "data" => $upazila ? $upazila : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
        return $response;
    }

    /**
     * @param array $data
     * @return LocUpazila
     */
    public function store(array $data): LocUpazila
    {
        return LocUpazila::create($data);
    }

    /**
     * @param $data
     * @param LocUpazila $locUpazila
     * @return bool
     */
    public function update($data, LocUpazila $locUpazila): LocUpazila
    {
        $locUpazila->fill($data);
        $locUpazila->save();
        return $locUpazila;
    }

    /**
     * @param LocUpazila $locUpazila
     * @return bool
     */
    public function destroy(LocUpazila $locUpazila): LocUpazila
    {
        $locUpazila->row_status = LocUpazila::ROW_STATUS_DELETED;
        $locUpazila->save();
        return $locUpazila;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'loc_district_id' => 'required|numeric|exists:loc_districts,id', //TODO: always check if foreign key data exists in table.
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id', //TODO: always check if foreign key data exists in table.
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
        ]);
    }
}
