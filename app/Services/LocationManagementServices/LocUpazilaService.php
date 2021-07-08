<?php


namespace App\Services\LocationManagementServices;


use App\Models\LocDistrict;
use App\Models\LocUpazila;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\ErrorException;
use Ramsey\Uuid\Type\Integer;


class LocUpazilaService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getAllUpazilas(Request $request)
    {
        $paginate_link = [];
        $page = [];
        $startTime = Carbon::now();

        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var LocUpazila|Builder $upazilas */
        $upazilas = LocUpazila::select([
            'loc_upazilas.id',
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

        if (!empty($request->query('title_en'))) {
            $upazilas->where('loc_upazilas.title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $upazilas->where('loc_upazilas.title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }
        if ($paginate) {
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
            $_links['view'] = route('api.v1.upazilas.view', ['id' => $upazila->id]);
            $_links['edit'] = route('api.v1.upazilas.view', ['id' => $upazila->id]);
            $_links['delete'] = route('api.v1.upazilas.destroy', ['id' => $upazila->id]);
            $upazila['_links'] = $_links;
            $data[] = $upazila->toArray();

        }
        $response = [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
                'search' => [
                    'parameters' => [
                        'title_en',
                        'title_bn'
                    ],
                    '_link' => route('api.v1.upazilas.view-all')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];
        return $response;
    }

    /**
     * @param $id
     * @return array
     */
    public function getOneUpazila($id)
    {
        $startTime = Carbon::now();
        $links = [];

        $upazila = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.title_bn',
            'loc_upazilas.title_en',
            'loc_districts.title_bn as district_title_bn',
            'loc_districts.title_en as district_title_en',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ])->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
            ->leftJoin('loc_districts', 'loc_districts.id', '=', 'loc_upazilas.loc_division_id')
            ->where([
                'loc_upazilas.id' => $id,
                'loc_upazilas.row_status' => 1
            ])->first();

        if (!empty($upazila)) {
            $links = [
                'edit' => route('api.v1.upazilas.view', ['id' => $upazila->id]),
                'delete' => route('api.v1.upazilas.destroy', ['id' => $upazila->id])
            ];
        }
        $response = [
            "data" => $upazila ? $upazila : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
        return $response;
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        LocUpazila::create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $update = LocUpazila::find($id);
        $update->fill($request->all());
        $update->save();
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $delete = LocUpazila::find($id);
        $delete->row_status = 99;
        $delete->save();
    }


    /**
     * @param $district_id
     * @return array
     */
    public function getUpazilaByDistrictId(Request $request, $district_id)
    {
        $startTime = Carbon::now();

        $upazilas = LocUpazila::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
        ])->where([
            'loc_district_id' => $district_id,
            'row_status' => 1
        ])->get()->toArray();


        $response = [
            "data" => $upazilas,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [

            ],
        ];
        return $response;
    }
}
