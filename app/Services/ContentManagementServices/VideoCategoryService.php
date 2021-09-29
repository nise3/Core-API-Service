<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\VideoCategory;
use Symfony\Component\HttpFoundation\Response;


class VideoCategoryService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllVideoCategories(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $videoCategoryBuilder */
        $videoCategoryBuilder = VideoCategory::select([
            'video_categories.id',
            'video_categories.institute_id',
            'video_categories.organization_id',
            'video_categories.title_en',
            'video_categories.title_bn',
            'video_categories.parent_id',
            'parent.title_en as parent_category_title_en',
            'parent.title_bn as parent_category_title_bn',
            'video_categories.row_status',
            'video_categories.created_at',
            'video_categories.updated_at',
        ]);

        $videoCategoryBuilder->leftJoin('video_categories as parent', function ($join) use ($rowStatus) {
            $join->on('parent.id', '=', 'video_categories.parent_id')
                ->whereNull('parent.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('parent.row_status', $rowStatus);
            }
        });
        $videoCategoryBuilder->orderBy('video_categories.id', $order);

        if (is_numeric($rowStatus)) {
            $videoCategoryBuilder->where('video_categories.row_status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $videoCategoryBuilder->where('video_categories.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $videoCategoryBuilder->where('video_categories.title_bn', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $videoCategories */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $videoCategories = $videoCategoryBuilder->paginate($pageSize);
            $paginateData = (object)$videoCategories->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $videoCategories = $videoCategoryBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $videoCategories->toArray()['data'] ?? $videoCategories->toArray();
        $response['response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];
        return $response;
    }

    /**
     * @param int $id
     * @param Carbon $startTime
     * @return array
     */
    public function getOneVideoCategory(int $id, Carbon $startTime): array
    {
        /** @var Builder $videoCategoryBuilder */
        $videoCategoryBuilder = VideoCategory::select([
            'video_categories.id',
            'video_categories.institute_id',
            'video_categories.organization_id',
            'video_categories.title_en',
            'video_categories.title_bn',
            'video_categories.parent_id',
            'parent.title_en as parent_category_title_en',
            'parent.title_bn as parent_category_title_bn',
            'video_categories.row_status',
            'video_categories.created_at',
            'video_categories.updated_at',
        ]);

        $videoCategoryBuilder->leftJoin('video_categories as parent', function ($join) {
            $join->on('parent.id', '=', 'video_categories.parent_id')
                ->whereNull('parent.deleted_at');
        });
        $videoCategoryBuilder->where('video_categories.id', $id);

        /** @var VideoCategory $videoCategory */
        $videoCategory = $videoCategoryBuilder->first();

        return [
            "data" => $videoCategory ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }


    /**
     * @param array $data
     * @return VideoCategory
     */
    public function store(array $data): VideoCategory
    {
        $videoCategory = new VideoCategory();
        $videoCategory->fill($data);
        $videoCategory->save();
        return $videoCategory;
    }

    /**
     * @param VideoCategory $videoCategory
     * @param array $data
     * @return VideoCategory
     */
    public function update(VideoCategory $videoCategory, array $data): VideoCategory
    {
        $videoCategory->fill($data);
        $videoCategory->save();
        return $videoCategory;
    }


    /**
     * @param VideoCategory $videoCategory
     * @return bool
     */
    public function destroy(VideoCategory $videoCategory): bool
    {
        return $videoCategory->delete();
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
            'institute_id' => [
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
            ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:video_categories,id',
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];

        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
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
            'title_bn' => 'nullable|max:500|min:2',
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
