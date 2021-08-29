<?php

namespace App\Services\LocationManagementServices;

use App\Models\BaseModel;
use App\Models\LocDivision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $limit = $request->query('limit');
        $rowStatus = $request->query('row_status');
        $order = $request->query('order', 'ASC');

        /** @var Builder $divisionsBuilder */
        $divisionsBuilder = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
            'row_status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ]);
        $divisionsBuilder->orderBy('id', $order);

        if (!is_null($rowStatus)) {
            $divisionsBuilder->where('row_status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $divisionsBuilder->where('title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $divisionsBuilder->where('title_bn', 'like', '%' . $titleBn . '%');
        }

        if (!is_null($paginate) || !is_null($limit)) {
            $limit = $limit ?: 10;
            $divisionsBuilder = $divisionsBuilder->paginate($limit);
            $paginateData = (object)$divisionsBuilder->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $divisionsBuilder = $divisionsBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $divisionsBuilder->toArray()['data'] ?? $divisionsBuilder->toArray();
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
        /** @var LocDivision|Builder $divisionsBuilder */
        $divisionsBuilder = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
            'row_status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ]);
        $divisionsBuilder->where('id', $id);

        /** @var  $divisions */
        $divisions = $divisionsBuilder->first();

        return [
            "data" => $divisions ?: [],
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
