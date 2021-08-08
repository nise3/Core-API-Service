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
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDistricts(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';
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
        $districts->where('loc_districts.row_status', LocDistrict::ROW_STATUS_ACTIVE);

        if (!empty($titleEn)) {
            $districts->where('loc_districts.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $districts->where('loc_districts.title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!empty($divisionId)) {
            $districts->where('loc_districts.loc_division_id', $divisionId);
        }

        if (!empty($paginate)) {
            $districts = $districts->paginate(10);
            $paginateData = (object)$districts->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $districts = $districts->get();
        }

        $data = [];
        foreach ($districts as $district) {
            $links['read'] = route('api.v1.districts.read', ['id' => $district->id]);
            $links['update'] = route('api.v1.districts.update', ['id' => $district->id]);
            $links['delete'] = route('api.v1.districts.destroy', ['id' => $district->id]);
            $district['_links'] = $links;
            $data[] = $district->toArray();
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
                    '_link' => route('api.v1.districts.get-list')
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
    public function getOneDistrict(int $id, Carbon $startTime): array
    {
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
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
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
     * @return bool
     */
    public function destroy(LocDistrict $locDistrict): bool
    {
        return $locDistrict->delete();
    }

    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'loc_division_id' => 'required|numeric|exists:loc_divisions,id',
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            'bbs_code' => 'nullable|min:1',
            'division_bbs_code' => 'nullable|min:1|exists:loc_divisions,bbs_code'
        ]);
    }
}
