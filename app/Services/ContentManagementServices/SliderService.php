<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SliderService
{
    public function getAllSliders(array $request, Carbon $startTime): array
    {

        $titleEn = $request['title_en'] ?? "";
        $subTitleEn = $request['sub_title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $subTitleBn = $request['sub_title_bn'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $sliderBuilder */

        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.institute_id',
            'sliders.organization_id',
            'sliders.title_en',
            'sliders.title_bn',
            'sliders.sub_title_en',
            'sliders.sub_title_bn',
            'sliders.is_button_available',
            'sliders.link',
            'sliders.button_text',
            'sliders.slider_images',
            'sliders.alt_title_en',
            'sliders.alt_title_bn',
            'sliders.row_status',
            'sliders.created_at',
            'sliders.updated_at',

        ]);
        $sliderBuilder->orderBy('sliders.id', $order);

        if (is_numeric($rowStatus)) {
            $sliderBuilder->where('sliders.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $sliderBuilder->where('sliders.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $sliderBuilder->where('sliders.title_bn', 'like', '%' . $titleBn . '%');
        }
        if (!empty($subTitleEn)) {
            $sliderBuilder->where('sliders.sub_title_en', 'like', '%' . $subTitleEn . '%');
        }
        if (!empty($subTitleBn)) {
            $sliderBuilder->where('sliders.sub_title_bn', 'like', '%' . $subTitleBn . '%');
        }


        /** @var Collection $sliders */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $sliders = $sliderBuilder->paginate($pageSize);
            $paginateData = (object)$sliders->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $sliders = $sliderBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $sliders->toArray()['data'] ?? $sliders->toArray();
        $response['response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];
        return $response;

    }

    public function getOneSlider(int $id, Carbon $startTime): array
    {
        /** @var Builder $sliderBuilder */

        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.institute_id',
            'sliders.organization_id',
            'sliders.title_en',
            'sliders.title_bn',
            'sliders.sub_title_en',
            'sliders.sub_title_bn',
            'sliders.is_button_available',
            'sliders.link',
            'sliders.button_text',
            'sliders.slider_images',
            'sliders.alt_title_en',
            'sliders.alt_title_bn',
            'sliders.row_status',
            'sliders.created_at',
            'sliders.updated_at',
        ]);
        $sliderBuilder->where('sliders.id', $id);


        /** @var Slider $slider */
        $slider = $sliderBuilder->first();

        return [
            "data" => $slider ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }

    /**
     * @param array $data
     * @return Slider
     */
    public function store(array $data): Slider
    {
        $slider = new Slider();
        $slider->fill($data);
        $slider->save();
        return $slider;
    }

    /**
     * @param Slider $slider
     * @param array $data
     * @return Slider
     */
    public function update(Slider $slider, array $data): Slider
    {

        $slider->fill($data);
        $slider->save();
        return $slider;
    }

    /**
     * @param Slider $slider
     * @return bool
     */
    public function destroy(Slider $slider): bool
    {
        return $slider->delete();
    }

    /**
     * @param $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        if (!empty($request["slider_images"])) {
            $request["slider_images"] = is_array($request['slider_images']) ? $request['slider_images'] : explode(',', $request['slider_images']);
        }
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'title_bn' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'sub_title_en' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'sub_title_bn' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'is_button_available' => [
                'required',
                'int',
                Rule::in([Slider::IS_BUTTON_AVAILABLE_YES, Slider::IS_BUTTON_AVAILABLE_NO])
            ],
            'link' => [
                'nullable',
                'requiredIf:is_button_available,' . Slider::IS_BUTTON_AVAILABLE_YES,
                'string',
                'max:191',
            ],
            'button_text' => [
                'nullable',
                'requiredIf:is_button_available,' . Slider::IS_BUTTON_AVAILABLE_YES,
                'string',
                'max:20'
            ],

            'institute_id' => [
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
            ],
            'slider_images' => [
                'required',
                'array',
            ],
            'slider_images.*' => [
                'string',
            ],
            'alt_title_en' => [
                'string',
                'nullable'
            ],
            'alt_title_bn' => [
                'string',
                'nullable'
            ],

            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]

        ];

        return Validator::make($request->all(), $rules, $customMessage);
    }


    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
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
        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:191|min:2',
            'sub_title_en' => 'nullable|max:500|min:2',
            'title_bn' => 'nullable|max:191|min:2',
            'sub_title_bn' => 'nullable|max:500|min:2',
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
        ], $customMessage);
    }

}
