<?php

namespace App\Services\ContentManagementServices;


use App\Models\BaseModel;
use App\Models\Partner;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class PartnerService
{


    public function getPartnerList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? null;
        $titleBn = $request['title_bn'] ?? null;

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
    public function validation(Request $request): \Illuminate\Contracts\Validation\Validator
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
