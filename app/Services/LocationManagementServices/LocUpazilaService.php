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
    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllUpazilas(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $paginate = $request->query('page');
        $districtId = $request->query('district_id');
        $divisionId = $request->query('division_id');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var LocUpazila|Builder $upazilas */
        $upazilas = LocUpazila::select([
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
        ]);
        $upazilas->leftJoin('loc_divisions', 'loc_divisions.id', '=', 'loc_upazilas.loc_division_id');
        $upazilas->leftJoin('loc_districts', 'loc_districts.id', '=', 'loc_upazilas.loc_division_id');

        $upazilas->orderBy('loc_upazilas.id', $order);
        $upazilas->where('loc_districts.row_status', LocUpazila::ROW_STATUS_ACTIVE);
        if (!empty($request->query('title_en'))) {
            $upazilas->where('loc_upazilas.title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $upazilas->where('loc_upazilas.title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }

        if (!empty($districtId)) {
            $upazilas->where('loc_upazilas.loc_district_id', $districtId);
        }

        if (!empty($divisionId)) {
            $upazilas->where('loc_upazilas.loc_division_id', $divisionId);
        }

        if (!empty($paginate)) {
            $upazilas = $upazilas->paginate(10);
            $paginateData = (object)$upazilas->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $upazilas = $upazilas->get();
        }

        $data = [];
        foreach ($upazilas as $upazila) {
            $links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $upazila->id]);
            $links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $upazila->id]);
            $links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $upazila->id]);
            $upazila['_links'] = $links;
            $data[] = $upazila->toArray();
        }
        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ],
            "_links" => [
                'paginate' => $paginateLink,
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
     * @param Carbon $startTime
     * @return array
     */
    public function getOneUpazila(int $id, Carbon $startTime): array
    {
        $links = [];

        /** @var LocUpazila|Builder $upazila */
        $upazila = LocUpazila::select([
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
        ]);
        $upazila->join('loc_divisions', 'loc_divisions.id', '=', 'loc_upazilas.loc_division_id');
        $upazila->join('loc_districts', 'loc_districts.id', '=', 'loc_upazilas.loc_division_id');
        $upazila->where('loc_upazilas.id', $id);
        $upazila = $upazila->first();

        if (!empty($upazila)) {
            $links = [
                'update' => route('api.v1.upazilas.update', ['id' => $upazila->id]),
                'delete' => route('api.v1.upazilas.destroy', ['id' => $upazila->id])
            ];
        }

        return [
            "data" => $upazila ?: null,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ],
            "_links" => $links
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
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'loc_district_id' => 'required|numeric|exists:loc_districts,id',
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id',
            'division_bbs_code' => 'nullable|min:1|exists:loc_divisions,bbs_code',
            'district_bbs_code' => 'nullable|min:1|exists:loc_districts,bbs_code',
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            'bbs_code' => 'nullable|min:1'
        ]);
    }
}
