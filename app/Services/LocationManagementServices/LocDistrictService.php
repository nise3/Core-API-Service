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
        $paginate = $request->query('page', 10);
        $limit = $request->query('limit');
        $rowStatus = $request->query('row_status');
        $order = $request->query('order', 'ASC');
        $divisionId = $request->query('division_id');

        /** @var Builder $districtsBuilder */
        $districtsBuilder = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.loc_division_id',
            'loc_districts.title_bn',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
            'loc_districts.row_status',
            'loc_districts.created_by',
            'loc_districts.updated_by',
            'loc_districts.created_at',
            'loc_districts.updated_at'

        ]);

        $districtsBuilder->leftJoin('loc_divisions', function ($join) use ($rowStatus) {
            $join->on('loc_divisions.id', '=', 'loc_districts.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
            if (!is_null($rowStatus)) {
                $join->where('loc_divisions.row_status', $rowStatus);
            }
        });

        $districtsBuilder->orderBy('loc_districts.id', $order);

        if (!is_null($rowStatus)) {
            $districtsBuilder->where('loc_districts.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $districtsBuilder->where('loc_districts.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $districtsBuilder->where('loc_districts.title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!empty($divisionId)) {
            $districtsBuilder->where('loc_districts.loc_division_id', $divisionId);
        }

        if (!is_null($paginate) || !is_null($limit)) {
            $limit = $limit ?: 10;
            $districtsBuilder = $districtsBuilder->paginate($limit);
            $paginateData = (object)$districtsBuilder->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $districtsBuilder = $districtsBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $districtsBuilder->toArray()['data'] ?? $districtsBuilder->toArray();
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
        /** @var Builder $districtBuilder */
        $districtBuilder = LocDistrict::select([
            'loc_districts.id',
            'loc_districts.loc_division_id',
            'loc_districts.title_bn',
            'loc_districts.title_en',
            'loc_districts.bbs_code',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
            'loc_districts.row_status',
            'loc_districts.created_by',
            'loc_districts.updated_by',
            'loc_districts.created_at',
            'loc_districts.updated_at'
        ]);

        $districtBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_districts.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $districtBuilder->where('loc_districts.id', $id);
        $district = $districtBuilder->first();
        return [
            "data" => $district ?: [],
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
