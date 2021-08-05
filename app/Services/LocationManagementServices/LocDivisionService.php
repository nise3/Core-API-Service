<?php

namespace App\Services\LocationManagementServices;

use App\Models\LocDivision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class LocService
 * @package App\Services\Sevices
 */
class LocDivisionService
{
    const ROUTE_PREFIX = 'api.v1.divisions.';

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDivisions(Request $request, Carbon $startTime): array
    {
        $paginateLink = [];
        $page = [];
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var LocDivision|Builder $divisions */
        $divisions = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
        ]);
        $divisions->orderBy('id', $order);
        $divisions->where('row_status', LocDivision::ROW_STATUS_ACTIVE);

        if (!empty($request->query('title_en'))) {
            $divisions->where('title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $divisions->where('title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }

        if ($paginate) {
            $divisions = $divisions->paginate(10);
            $paginateData = (object)$divisions->toArray();
            $page = [
                "size" => $paginateData->per_page,
                "total_element" => $paginateData->total,
                "total_page" => $paginateData->last_page,
                "current_page" => $paginateData->current_page
            ];
            $paginateLink = $paginateData->links;
        } else {
            $divisions = $divisions->get();
        }

        $data = [];
        foreach ($divisions as $division) {
            $links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $division->id]);
            $links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $division->id]);
            $links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $division->id]);
            $division['_links'] = $links;
            $data[] = $division->toArray();

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
    public function getOneDivision(int $id, Carbon $startTime): array
    {
        $links = [];

        /** @var LocDivision|Builder $division */
        $division = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code'
        ])->where([
            'id' => $id,
            'row_status' => LocDivision::ROW_STATUS_ACTIVE
        ])->first();

        if (!empty($division)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $division->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $division->id])
            ];
        }

        return [
            "data" => $division ? $division : [],
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
     * @return LocDivision
     */
    public function store(array $data): LocDivision
    {
        return LocDivision::create($data);
    }

    /**
     * @param array $data
     * @param LocDivision $locDivision
     * @return LocDivision
     */
    public function update(array $data, LocDivision $locDivision): LocDivision
    {
        $locDivision->fill($data);
        $locDivision->save();
        return $locDivision;
    }

    /**
     * @param LocDivision $locDivision
     * @return bool
     */
    public function destroy(LocDivision $locDivision): bool
    {
        return $locDivision->delete();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
            'bbs_code'=>'nullable|min:1'
        ]);
    }
}
