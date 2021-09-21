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
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllDivisions(array $request, Carbon $startTime): array
    {
        $titleEn = array_key_exists('title_en', $request) ? $request['title_en'] : "";
        $titleBn = array_key_exists('title_bn', $request) ? $request['title_bn'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

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

        if (is_numeric($rowStatus)) {
            $divisionsBuilder->where('row_status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $divisionsBuilder->where('title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $divisionsBuilder->where('title_bn', 'like', '%' . $titleBn . '%');
        }

        $divisionsBuilder = $divisionsBuilder->get();

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
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];

        return Validator::make($request->all(), [
            'title_en' => 'required|string|max:191|min:2',
            'title_bn' => 'required|string|max:500|min:2',
            'bbs_code' => 'nullable|max:4|min:1',
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }

    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }
        $customMessage = [
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        return Validator::make($request->all(), [
            'title_en' => 'nullable|string|max:191|min:1',
            'title_bn' => 'nullable|max:500|string|min:1',
            'order' => [
                'string',
                Rule::in([(BaseModel::ROW_ORDER_ASC), (BaseModel::ROW_ORDER_DESC)])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
