<?php

namespace App\Services\ContentManagementServices;

use App\Helpers\Classes\FileHandler;
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

        $title = $request['title'] ?? "";
        $subTitle = $request['sub_title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

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
        if (!empty($data['slider'])) {
            $filename = FileHandler::storeFile($data['slider'], 'images/slider');
            $data['slider'] = 'images/slider/' . $filename;
        }
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
        if (!empty($data['slider'])) {
            if (!empty($slider->slider)) {
                FileHandler::deleteFile($slider->slider);
            }

            $filename = FileHandler::storeFile($data['slider'], 'images/slider');
            $data['slider'] = 'images/slider/' . $filename;
        }
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
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'sub_title' => [
                'required',
                'string',
                'max:500',
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
                'required',
                'int',
            ],
            'slider' => [
                'image',
                'max:512',
                'dimensions:max_width=1920,max_height=1080',
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
            'title' => 'nullable|max:500|min:2',
            'sub_title' => 'nullable|max:500|min:2',
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
