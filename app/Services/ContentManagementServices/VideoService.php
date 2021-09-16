<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class VideoService
{
    public function getAllVideos(array $request, Carbon $startTime): array
    {
        $titleEn = array_key_exists('title_en', $request) ? $request['title_en'] : "";
        $titleBn = array_key_exists('title_bn', $request) ? $request['title_bn'] : "";
        $paginate = array_key_exists('page', $request) ? $request['page'] : "";
        $pageSize = array_key_exists('page_size', $request) ? $request['page_size'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

        /** @var Builder $videoBuilder */
        $videoBuilder = Video::select([
            'videos.id',
            'videos.title_en',
            'videos.title_bn',
            'videos.description',
            'videos.institute_id',
            'videos.video_category_id',
            'video_categories.title_en as video_category_title_en',
            'video_categories.title_bn as video_category_title_bn',
            'videos.uploaded_video_path',
            'videos.video_type',
            'videos.youtube_video_id',
            'videos.youtube_video_url',
            'videos.row_status',
            'videos.created_at',
            'videos.updated_at',
        ]);

        $videoBuilder->leftJoin('video_categories', function ($join) use ($rowStatus) {
            $join->on('videos.video_category_id', 'video_categories.id')
                ->whereNull('videos.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('video_categories.row_status', $rowStatus);
            }
        });
        $videoBuilder->orderBy('videos.id', $order);

        if (is_numeric($rowStatus)) {
            $videoBuilder->where('videos.row_status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $videoBuilder->where('videos.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $videoBuilder->where('videos.title_bn', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $videos */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $videos = $videoBuilder->paginate($pageSize);
            $paginateData = (object)$videos->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $videos = $videoBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $videos->toArray()['data'] ?? $videos->toArray();
        $response['response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];
        return $response;
    }

    public function getOneVideoCategory(int $id, Carbon $startTime)
    {
        /** @var Builder $videoBuilder */
        $videoBuilder = Video::select([
            'videos.id',
            'videos.title_en',
            'videos.title_bn',
            'videos.description',
            'videos.institute_id',
            'videos.video_category_id',
            'video_categories.title_en as video_category_title_en',
            'video_categories.title_bn as video_category_title_bn',
            'videos.uploaded_video_path',
            'videos.video_type',
            'videos.youtube_video_id',
            'videos.youtube_video_url',
            'videos.row_status',
            'videos.created_at',
            'videos.updated_at',
        ]);

        $videoBuilder->leftJoin('video_categories', function ($join) {
            $join->on('videos.video_category_id', 'video_categories.id')
                ->whereNull('videos.deleted_at');
        });
        $videoBuilder->where('videos.id', $id);

        /** @var Video $video */
        $video = $videoBuilder->first();

        return [
            "data" => $video ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }

    /**
     * @param array $data
     * @return Video
     */
    public function store(array $data): Video
    {
        $video = new Video();
        $video->fill($data);
        $video->save();
        return $video;
    }

    /**
     * @param Video $video
     * @param array $data
     * @return Video
     */
    public function update(Video $video, array $data): Video
    {
        $video->fill($data);
        $video->save();
        return $video;
    }


    /**
     * @param Video $video
     * @return bool
     */
    public function destroy(Video $video): bool
    {
        return $video->delete();
    }

    /**
     * @param $request
     * @param null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($request, $id = null): \Illuminate\Contracts\Validation\Validator
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
            ],
            'title_bn' => [
                'required',
                'string',
                'max:191',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'video_type' => [
                'required',
                'int',
                Rule::in([Video::VIDEO_TYPE_YOUTUBE_VIDEO, Video::VIDEO_TYPE_UPLOADED_VIDEO])
            ],
            'youtube_video_id' => [
                'nullable',
                'string',
                'max: 20',
                'required_if: video_type,' . Video::VIDEO_TYPE_YOUTUBE_VIDEO,
            ],
            'youtube_video_url' => [
                'nullable',
                'string',
                'max: 191',
            ],
            'uploaded_video_path' => [
                'nullable',
                'required_if:video_type,' . Video::VIDEO_TYPE_UPLOADED_VIDEO,
            ],

            'institute_id' => [
                'required',
                'int'
            ],
            'video_category_id' => [
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
            'title_en' => 'nullable|min:1',
            'title_bn' => 'nullable|min:1',
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