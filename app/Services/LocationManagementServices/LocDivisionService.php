<?php

namespace App\Services\LocationManagementServices;

use App\Models\BaseModel;
use App\Models\LocDivision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LocService
 * @package App\Services\Sevices
 */
class LocDivisionService
{
    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDivisions(Request $request, Carbon $startTime): array
    {
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $order = $request->query('order', 'ASC');

        /** @var LocDivision|Builder $divisions */
        $divisions = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
        ]);
        $divisions->orderBy('id', $order);
        $divisions->where('row_status', BaseModel::ROW_STATUS_ACTIVE);

        if (!empty($request->query('title_en'))) {
            $divisions->where('title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $divisions->where('title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }

        if ($paginate || $limit) {
            $limit = $limit ?: 10;
            $divisions = $divisions->paginate($limit);
            $paginateData = (object)$divisions->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $divisions = $divisions->get();
        }

        $response['order'] = $order;
        $response['data'] = $divisions->toArray()['data'] ?? $divisions->toArray();
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
    public function getOneDivision(int $id, Carbon $startTime): array
    {
        /** @var LocDivision|Builder $division */
        $division = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code'
        ])->where([
            'id' => $id,
            'row_status' => BaseModel::ROW_STATUS_ACTIVE
        ])->first();

        return [
            "data" => $division ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
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
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
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
