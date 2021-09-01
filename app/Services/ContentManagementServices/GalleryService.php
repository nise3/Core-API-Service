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
    public function getAllGalleries(array $request, Carbon $startTime): array
    {
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
            'galleries.galleries.institute_id',
            'galleries.you_tube_video_id',
            'galleries.gallery_category_id',
            'gallery_categories.title_en as gallery_category_title_en',
            'gallery_categories.title_bn as gallery_category_title_bn',
            'galleries.is_youtube_video',
            'galleries.publish_date',
            'galleries.archive_date',
            'galleries.created_by',
            'galleries.updated_by',
            'gallery_categories.created_at',
            'gallery_categories.updated_at'

        ]);
        $galleryBuilder->join('gallery_categories', function ($join) use ($rowStatus) {
            $join->on('galleries.gallery_category_id', '=', 'gallery_categories.id');
            if (is_numeric($rowStatus)) {
                $join->where('gallery_categories.row_status', $rowStatus);
            }
        });
        $galleryBuilder->orderBy('galleries.id', $order);

        if (is_numeric($rowStatus)) {
            $galleryBuilder->where('gallery_categories.row_status', $rowStatus);
        }

        /** @var Collection $organizations */

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

    public function getOneGallery(int $id, Carbon $startTime)
    {
        /** @var Builder $galleryBuilder */
        $galleryBuilder = Gallery::select([
            'galleries.id',
            'galleries.content_title',
            'galleries.content_type',
            'galleries.content_path',
            'galleries.galleries.institute_id',
            'galleries.you_tube_video_id',
            'galleries.gallery_category_id',
            'gallery_categories.title_en as gallery_category_title_en',
            'gallery_categories.title_bn as gallery_category_title_bn',
            'galleries.is_youtube_video',
            'galleries.publish_date',
            'galleries.archive_date',
            'galleries.created_by',
            'galleries.updated_by',
            'gallery_categories.created_at',
            'gallery_categories.updated_at'

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

    public function store(array $data): Gallery
    {
        $gallery = new Gallery();
        $gallery->fill($data);
        $gallery->save();
        return $gallery;
    }


    public function update(Gallery $gallery, array $data): Gallery
    {
        $gallery->fill($data);
        $gallery->save();
        return $gallery;
    }


    public function destroy(Gallery $gallery): bool
    {
        return $gallery->delete();
    }


    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        //dd($request->content_path);
        $contentType = Gallery::CONTENT_TYPES;
        $rules = [
            'gallery_category_id' => ['required', 'int', 'exists:gallery_categories,id'],
            'content_title' => ['required', 'string', 'max:191'],
            'institute_id' => ['required', 'int', 'exists:institutes,id'],
            'content_type' => ['required', 'int', Rule::in(array_keys($contentType))],
            'is_youtube_video' => ['required_if:' . Gallery::CONTENT_TYPES[$request->content_type] . ',Image'],
            //'you_tube_video_id' => ['required_if:is_youtube_video,1', 'regex:/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/'],
            'publish_date' => ['date'],
            'archive_date' => ['date', 'after:publish_date'],
        ];

        if ($request->content_type == Gallery::CONTENT_TYPE_IMAGE) {
            $rules['content_path'] = ['required_without:id', 'string'];
            if (empty($request->content_path)) {
                unset($rules['content_path']);
            }
        } elseif (Gallery::CONTENT_TYPE_VIDEO == $request->content_type && $request->is_youtube_video == 0) {
            $rules['content_path'] = ['required_without:id', 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4'];
            if (empty($request->content_path)) {
                unset($rules['content_path']);
            }
        } elseif (Gallery::CONTENT_TYPE_VIDEO == $request->content_type && $request->is_youtube_video == 1) {
            $rules['you_tube_video_id'] = ['required_if:is_youtube_video,1', 'regex:/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/'];
        }

        return Validator::make($request->all(), $rules);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
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
