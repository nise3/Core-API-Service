<?php

namespace App\Services\ContentManagementServices;


use App\Models\BaseModel;
use App\Models\Partner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;
use Symfony\Component\HttpFoundation\Response;


class PartnerService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getPartnerList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request["order"] ?? "ASC";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";

        /** @var Builder $partnerBuilder */
        $partnerBuilder = Partner::select([
            "id",
            "title_en",
            "title_bn",
            "image",
            "domain",
            "alt_title_en",
            "alt_title_bn",
            "created_by",
            "updated_by",
            "created_at",
            "updated_at",
        ]);

        $partnerBuilder->orderBy("id", $order);

        if (is_numeric($rowStatus)) {
            $partnerBuilder->where('partners.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $partnerBuilder->where("partners.title_en", "=", $titleEn);
        }

        if (!empty($titleBn)) {
            $partnerBuilder->where("partners.title_en", "=", $titleBn);
        }

        $response['order'] = $order;

        /** @var Partner $partner */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $users = $partnerBuilder->paginate($pageSize);
            $paginateData = (object)$users->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
            $response['data'] = $users->toArray()['data'] ?? [];
        } else {
            $users = $partnerBuilder->get();
            $response['data'] = $users->toArray() ?? [];
        }

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
    public function getOnePartner(int $id, Carbon $startTime): array
    {
        /** @var Builder $partnerBuilder */
        $partnerBuilder = Partner::select([
            "id",
            "title_en",
            "title_bn",
            "image",
            "domain",
            "alt_title_en",
            "alt_title_bn",
            "created_by",
            "updated_by",
            "created_at",
            "updated_at",
        ]);
        $partnerBuilder->whereNull("deleted_at");
        $partnerBuilder->where("id", $id);

        /** @var Partner $partner */
        $partner = $partnerBuilder->first();

        return [
            "data" => $partner ?? new stdClass(),
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];

    }

    /**
     * @param Partner $partner
     * @param array $data
     * @return Partner
     */
    public function store(Partner $partner, array $data): Partner
    {
        $partner->fill($data);
        $partner->save();
        return $partner;
    }

    /**
     * @param Partner $partner
     * @param array $data
     * @return Partner
     */
    public function update(Partner $partner, array $data): Partner
    {
        $partner->fill($data);
        $partner->save();
        return $partner;
    }

    /**
     * @param Partner $partner
     * @return bool
     */
    public function destroy(Partner $partner): bool
    {
        return $partner->delete();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        $customMessage = [
            "image.regex" => [
                "code" => 48000,
                "message" => "The image path format will be a uri with http/https"
            ],
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            "title_en" => "required|max:191|min:2",
            "title_bn" => "required|max:500|min:2",
            "image" => [
                "required",
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/'
            ],
            "domain" => [
                "nullable",
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/'
            ],
            "alt_title_en" => "nullable|min:2|max:191",
            "alt_title_bn" => "nullable|min:2|max:191",
            "created_by" => "nullable|numeric|gt:0",
            "updated_by" => "nullable|numeric|gt:0",
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidation(Request $request): \Illuminate\Contracts\Validation\Validator
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

        $rules = [
            "title_en" => "nullable",
            "title_bn" => "nullable",
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

}
