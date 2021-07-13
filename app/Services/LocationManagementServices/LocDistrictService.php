<?php


namespace App\Services\LocationManagementServices;


use App\Models\LocDistrict;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LocDistrictService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getAllDistricts(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $startTime = Carbon::now();

        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';
        $division_id = $request->query('division_id');

        /** @var LocDistrict|Builder $district */
        $districts = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.loc_division_id',
            'loc_districts.title_bn',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ]);
        $districts->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_districts.loc_division_id');
        $districts->orderBy('loc_districts.id', $order);
        $districts->where('loc_districts.row_status',LocDistrict::ROW_STATUS_ACTIVE);

        if (!empty($titleEn)) {
            $districts->where('loc_districts.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $districts->where('loc_districts.title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!empty($division_id)) {
            $districts->where('loc_districts.loc_division_id', $division_id);
        }

        if (!empty($paginate)) {
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
            $_links['read'] = route('api.v1.districts.read', ['id' => $district->id]);
            $_links['update'] = route('api.v1.districts.update', ['id' => $district->id]);
            $_links['delete'] = route('api.v1.districts.destroy', ['id' => $district->id]);
            $district['_links'] = $_links;
            $data[] = $district->toArray();

        }

        return [
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
                    '_link' => route('api.v1.districts.get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function getOneDistrict($id): array
    {
        $startTime = Carbon::now();
        $links = [];

        /** @var LocDistrict|Builder $district */
        $district = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.loc_division_id',
            'loc_districts.title_bn',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
        ]);
        $district->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_districts.loc_division_id');
        $district->where('loc_districts.id', $id);
        $district->where('loc_districts.row_status', LocDistrict::ROW_STATUS_ACTIVE);
        $district = $district->first();

        if (!empty($district)) {
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

    /**
     * @param array $data
     * @return LocDistrict
     */
    public function store(array $data): LocDistrict
    {
        $locDistrict = new LocDistrict();
        $locDistrict->fill($data);
        $locDistrict->save();

        return $locDistrict;
    }

    /**
     * @param LocDistrict $locDistrict
     * @param array $data
     * @return LocDistrict
     */
    public function update(LocDistrict $locDistrict, array $data): LocDistrict
    {
        $locDistrict->fill($data);
        $locDistrict->save();
        return $locDistrict;
    }

    /**
     * @param LocDistrict $locDistrict
     * @return LocDistrict
     */
    public function destroy(LocDistrict $locDistrict): LocDistrict
    {
        $locDistrict->row_status = LocDistrict::ROW_STATUS_DELETED;
        $locDistrict->save();

        return $locDistrict;
    }

    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id', //TODO: always check if foreign key data exists in table.
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
        ]);
    }
}
