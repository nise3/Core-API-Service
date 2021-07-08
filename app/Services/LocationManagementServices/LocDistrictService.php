<?php


namespace App\Services\LocationManagementServices;


use App\Models\LocDistrict;
use App\Services\ServiseInterface\BaseServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\ErrorException;
use Ramsey\Uuid\Type\Integer;


class LocDistrictService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getAllDistricts(Request $request)
    {
        $paginate_link = [];
        $page = [];
        $startTime = Carbon::now();

        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var LocDistrict|Builder $district */
        $districts = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.title_bn',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ])->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_districts.loc_division_id');

        $districts->orderBy('loc_districts.id', $order);

        if (!empty($request->query('title_en'))) {
            $districts->where('loc_districts.title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $districts->where('loc_districts.title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }
        if ($paginate) {
            $districts = $districts->paginate(10);
            $paginate_data = (object)$districts->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $districts = $districts->get();
        }

        $data = [];
        foreach ($districts as $district) {
            $_links['view'] = route('api.v1.districts.view', ['id' => $district->id]);
            $_links['edit'] = route('api.v1.districts.view', ['id' => $district->id]);
            $_links['delete'] = route('api.v1.districts.destroy', ['id' => $district->id]);
            $district['_links'] = $_links;
            $data[] = $district->toArray();

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
                    '_link' => route('api.v1.districts.view-all')
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
    public function getOneDistrict($id)
    {
        $startTime = Carbon::now();
        $links = [];

        $district = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.title_bn',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ])->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_districts.loc_division_id')
            ->where([
                'loc_districts.id' => $id,
                'loc_districts.row_status' => 1
            ])->first();
        if (!empty($district)) {
            $links = [
                'edit' => route('api.v1.districts.view', ['id' => $district->id]),
                'delete' => route('api.v1.districts.destroy', ['id' => $district->id])
            ];
        }
        $response = [
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
        return $response;
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        LocDistrict::create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $update = LocDistrict::find($id);
        $update->fill($request->all());
        $update->save();
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $delete = LocDistrict::find($id);
        $delete->row_status = 99;
        $delete->save();
    }


    /**
     * @param $division_id
     * @return array
     */
    public function getDistrictByDivisionId(Request $request, $division_id)
    {
        $startTime = Carbon::now();

        $districts = LocDistrict::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
        ])->where([
            'loc_division_id' => $division_id,
            'row_status' => 1
        ])->get()->toArray();


        $response = [
            "data" => $districts,
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
