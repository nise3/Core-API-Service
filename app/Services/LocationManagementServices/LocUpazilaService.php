<?php


namespace App\Services\LocationManagementServices;


use App\Models\BaseModel;
use App\Models\LocUpazila;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class LocUpazilaService
{
    const ROUTE_PREFIX = 'api.v1.upazilas.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllUpazilas(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page', 10);
        $limit = $request->query('limit');
        $rowStatus = $request->query('row_status');
        $districtId = $request->query('district_id');
        $divisionId = $request->query('division_id');
        $order = $request->query('order', 'ASC');

        /** @var LocUpazila|Builder $upazilasBuilder */
        $upazilasBuilder = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.loc_district_id',
            'loc_upazilas.loc_division_id',
            'loc_upazilas.title_bn',
            'loc_upazilas.title_en',
            'loc_upazilas.bbs_code',
            'loc_districts.title_bn as district_title_bn',
            'loc_districts.title_en as district_title_en',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
            'loc_upazilas.row_status',
            'loc_upazilas.created_by',
            'loc_upazilas.updated_by',
            'loc_upazilas.created_at',
            'loc_upazilas.updated_at'
        ]);

        $upazilasBuilder->leftJoin('loc_divisions', function ($join) use ($rowStatus) {
            $join->on('loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
            if (!is_null($rowStatus)) {
                $join->where('loc_divisions.row_status', $rowStatus);
            }
        });

        $upazilasBuilder->leftJoin('loc_districts', function ($join) use ($rowStatus) {
            $join->on('loc_upazilas.loc_district_id', '=', 'loc_districts.id')
                ->whereNull('loc_districts.deleted_at');
            if (!is_null($rowStatus)) {
                $join->where('loc_districts.row_status', $rowStatus);
            }
        });

        $upazilasBuilder->orderBy('loc_upazilas.id', $order);

        if (!is_null($rowStatus)) {
            $upazilasBuilder->where('loc_upazilas.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $upazilasBuilder->where('loc_upazilas.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $upazilasBuilder->where('loc_upazilas.title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!empty($districtId)) {
            $upazilasBuilder->where('loc_upazilas.loc_district_id', $districtId);
        }

        if (!empty($divisionId)) {
            $upazilasBuilder->where('loc_upazilas.loc_division_id', $divisionId);
        }

        if (!is_null($paginate) || !is_null($limit)) {
            $limit = $limit ?: 10;
            $upazilasBuilder = $upazilasBuilder->paginate($limit);
            $paginateData = (object)$upazilasBuilder->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $upazilasBuilder = $upazilasBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $upazilasBuilder->toArray()['data'] ?? $upazilasBuilder->toArray();
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
    public function getOneUpazila(int $id, Carbon $startTime): array
    {
        /** @var LocUpazila|Builder $upazilaBuilder */
        $upazilaBuilder = LocUpazila::select([
            'loc_upazilas.id',
            'loc_upazilas.loc_district_id',
            'loc_upazilas.loc_division_id',
            'loc_upazilas.title_bn',
            'loc_upazilas.title_en',
            'loc_upazilas.bbs_code',
            'loc_districts.title_bn as district_title_bn',
            'loc_districts.title_en as district_title_en',
            'loc_districts.division_bbs_code',
            'loc_divisions.title_bn as division_title_bn',
            'loc_divisions.title_en as division_title_en',
            'loc_upazilas.row_status',
            'loc_upazilas.created_by',
            'loc_upazilas.updated_by',
            'loc_upazilas.created_at',
            'loc_upazilas.updated_at'
        ]);

        $upazilaBuilder->leftJoin('loc_divisions', function ($join) {
            $join->on('loc_divisions.id', '=', 'loc_upazilas.loc_division_id')
                ->whereNull('loc_divisions.deleted_at');
        });

        $upazilaBuilder->leftJoin('loc_districts', function ($join) {
            $join->on('loc_districts.id', '=', 'loc_upazilas.loc_district_id')
                ->whereNull('loc_districts.deleted_at');
        });

        if (!empty($id)) {
            $upazilaBuilder->where('loc_upazilas.id', $id);
        }

        $upazila = $upazilaBuilder->first();
        return [
            "data" => $upazila ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];
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
     * @return LocUpazila
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
    public function destroy(LocUpazila $locUpazila): bool
    {
        return $locUpazila->delete();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'loc_district_id' => 'required|numeric|exists:loc_districts,id',
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id',
            'division_bbs_code' => 'nullable|min:1|exists:loc_divisions,bbs_code',
            'district_bbs_code' => 'nullable|min:1|exists:loc_districts,bbs_code',
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            'bbs_code' => 'nullable|min:1',
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ]);
    }
}
