<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class GalleryService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllGalleries(array $request, Carbon $startTime): array
    {

        $contentTitle = array_key_exists('content_title', $request) ? $request['content_title'] : "";
        $paginate = array_key_exists('page', $request) ? $request['page'] : "";
        $pageSize = array_key_exists('page_size', $request) ? $request['page_size'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

        /** @var Builder $galleryBuilder */
        $galleryBuilder = Gallery::select([
            'galleries.id',
            'galleries.content_title',
            'galleries.content_type',
            'galleries.content_path',
            'galleries.institute_id',
            'galleries.you_tube_video_id',
            'galleries.gallery_category_id',
            'gallery_categories.title_en as gallery_category_title_en',
            'gallery_categories.title_bn as gallery_category_title_bn',
            'galleries.is_youtube_video',
            'galleries.publish_date',
            'galleries.archive_date',
            'galleries.created_by',
            'galleries.updated_by',
            'galleries.created_at',
            'galleries.updated_at'

        ]);
        $galleryBuilder->join('gallery_categories', function ($join) use ($rowStatus) {
            $join->on('galleries.gallery_category_id', '=', 'gallery_categories.id');
            if (is_numeric($rowStatus)) {
                $join->where('gallery_categories.row_status', $rowStatus);
            }
        });
        $galleryBuilder->orderBy('galleries.id', $order);

        if (is_numeric($rowStatus)) {
            $galleryBuilder->where('galleries.row_status', $rowStatus);
        }
        if (!empty($contentTitle)) {
            $galleryBuilder->where('galleries.title_en', 'like', '%' . $contentTitle . '%');
        }

        /** @var Collection $galleries */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $galleries = $galleryBuilder->paginate($pageSize);
            $paginateData = (object)$galleries->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $galleries = $galleryBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $galleries->toArray()['data'] ?? $galleries->toArray();
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
    public function getOneGallery(int $id, Carbon $startTime): array
    {
        /** @var Builder $galleryBuilder */
        $galleryBuilder = Gallery::select([
            'galleries.id',
            'galleries.content_title',
            'galleries.content_type',
            'galleries.content_path',
            'galleries.institute_id',
            'galleries.you_tube_video_id',
            'galleries.gallery_category_id',
            'gallery_categories.title_en as gallery_category_title_en',
            'gallery_categories.title_bn as gallery_category_title_bn',
            'galleries.is_youtube_video',
            'galleries.publish_date',
            'galleries.archive_date',
            'galleries.created_by',
            'galleries.updated_by',
            'galleries.created_at',
            'galleries.updated_at'

        ]);
        $galleryBuilder->join('gallery_categories', function ($join) {
            $join->on('galleries.gallery_category_id', '=', 'gallery_categories.id');

        });
        $galleryBuilder->where('galleries.id', $id);

        /** @var Gallery $gallery */
        $gallery = $galleryBuilder->first();

        return [
            "data" => $gallery ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ]
        ];

    }

    /**
     * @param array $data
     * @return Gallery
     */
    public function store(array $data): Gallery
    {
        $gallery = new Gallery();
        $gallery->fill($data);
        $gallery->save();
        return $gallery;
    }

    /**
     * @param Gallery $gallery
     * @param array $data
     * @return Gallery
     */
    public function update(Gallery $gallery, array $data): Gallery
    {
        $gallery->fill($data);
        $gallery->save();
        return $gallery;
    }

    /**
     * @param Gallery $gallery
     * @return bool
     */
    public function destroy(Gallery $gallery): bool
    {
        return $gallery->delete();
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
        $rules = [
            'gallery_category_id' => [
                'required',
                'int',
                'exists:gallery_categories,id'
            ],
            'content_title' => [
                'required',
                'string',
                'max:191'
            ],
            'institute_id' => [
                'required',
                'int'
            ],
            'content_type' => [
                'required',
                'int',
                Rule::in([Gallery::CONTENT_TYPE_IMAGE, Gallery::CONTENT_TYPE_VIDEO])
            ],
            'is_youtube_video' => [
                'int',
                'required_if:content_type,' . Gallery::CONTENT_TYPE_VIDEO,
                Rule::in([Gallery::IS_YOUTUBE_VIDEO_YES, Gallery::IS_YOUTUBE_VIDEO_NO])
            ],
            'publish_date' => [
                'nullable',
                'date'
            ],
            'archive_date' => [
                'nullable',
                'date',
                'after:publish_date'
            ],
        ];

        if ($request->content_type == Gallery::CONTENT_TYPE_VIDEO && $request->is_youtube_video == Gallery::IS_YOUTUBE_VIDEO_YES) {
            $rules['you_tube_video_id'] = [
                'required_if:is_youtube_video,' . Gallery::IS_YOUTUBE_VIDEO_YES,
                'string'
            ];
        } else {
            $rules['content_path'] = [
                'required',
                'string'
            ];

        }

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
            'page' => 'numeric|gt:0',
            'pageSize' => 'numeric',
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
