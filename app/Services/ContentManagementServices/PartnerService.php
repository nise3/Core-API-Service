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

        $partnerBuilder->whereNull("deleted_at");
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

        /** @var Partner $partner */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $users = $partnerBuilder->paginate($pageSize);
            $paginateData = (object)$users->toArray();
            $response['data'] = $users->toArray()['data'] ?? [];
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
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
    public function validator(Request $request,int $id): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "title_en" => "required|max:191|min:2",
            "title_bn" => "required|max:500|min:2",
            "image" => [
                "required",
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/'
            ],
            "alt_title_en" => "nullable|min:2|max:191",
            "alt_title_bn" => "nullable|min:2|max:191"
        ];
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filtervalidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "title_en" => "nullable",
            "title_bn" => "nullable",
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules);
    }

}
