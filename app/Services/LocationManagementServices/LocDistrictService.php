<?php

namespace App\Services\LocationManagementServices;

use App\Models\BaseModel;
use App\Models\LocDistrict;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class LocDistrictService
{
    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDistricts(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $order = $request->query('order', 'ASC');
        $divisionId = $request->query('division_id');

        /** @var LocDistrict|Builder $districts */
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
        $districts->where('loc_districts.row_status', BaseModel::ROW_STATUS_ACTIVE);

        if (!empty($titleEn)) {
            $districts->where('loc_districts.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $districts->where('loc_districts.title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!empty($divisionId)) {
            $districts->where('loc_districts.loc_division_id', $divisionId);
        }

        if ($paginate || $limit) {
            $limit=$limit?:10;
            $districts = $districts->paginate($limit);
            $paginateData = (object)$districts->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $districts = $districts->get();
        }

        $response['order'] = $order;
        $response['data'] = $districts->toArray()['data'] ?? $districts->toArray();
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
    public function getOneDistrict(int $id, Carbon $startTime): array
    {
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
        $district->where('loc_districts.row_status', BaseModel::ROW_STATUS_ACTIVE);
        $district = $district->first();
        return [
            "data" => $district ? $district : [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
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
     * @return bool
     */
    public function destroy(LocDistrict $locDistrict): bool
    {
        return $locDistrict->delete();
    }

    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id',
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            'bbs_code' => 'nullable|min:1',
            'division_bbs_code' => 'nullable|min:1|exists:loc_divisions,bbs_code',
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ]);
    }
}
