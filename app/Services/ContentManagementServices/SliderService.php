<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SliderService
{
    public function getAllSliders(array $request, Carbon $startTime): array
    {

        $title = array_key_exists('title', $request) ? $request['title'] : "";
        $subTitle = array_key_exists('sub_title', $request) ? $request['sub_title'] : "";
        $paginate = array_key_exists('page', $request) ? $request['page'] : "";
        $pageSize = array_key_exists('page_size', $request) ? $request['page_size'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

        /** @var Builder $sliderBuilder */

        $sliderBuilder = Slider::select([
            'sliders.id',
            'sliders.institute_id',
            'sliders.title',
            'sliders.sub_title',
            'sliders.is_button_available',
            'sliders.link',
            'sliders.button_text',
            'sliders.slider',
            'sliders.row_status',
            'sliders.created_at',
            'sliders.updated_at',

        ]);
        $sliderBuilder->orderBy('sliders.id', $order);

        if (is_numeric($rowStatus)) {
            $sliderBuilder->where('sliders.row_status', $rowStatus);
        }

        if (!empty($title)) {
            $sliderBuilder->where('sliders.title', 'like', '%' . $title . '%');
        } elseif (!empty($subTitle)) {
            $sliderBuilder->where('sliders.sub_title', 'like', '%' . $subTitle . '%');
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
            'sliders.title',
            'sliders.sub_title',
            'sliders.is_button_available',
            'sliders.link',
            'sliders.button_text',
            'sliders.slider',
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
        $rules = [
            'title' => [
                'required',
                'string',
                'max:191',
            ],
            'sub_title' => [
                'required',
                'string',
                'max:191',
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
                'max:191'
            ],

            'institute_id' => [
                'required',
                'int',
            ],
            'slider' => [
                'nullable',
                'string',
                'max:191'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]

        ];

        return Validator::make($request->all(), $rules);
    }


    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC',
            'row_status.in' => 'Row status must be within 1 or 0'
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'title' => 'nullable|min:1',
            'sub_title' => 'nullable|min:1',
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric',
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
