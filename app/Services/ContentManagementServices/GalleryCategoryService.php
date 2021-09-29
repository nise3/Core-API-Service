<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GalleryCategoryService
 * @package App\Services\ContentManagementServices
 */
class GalleryCategoryService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllGalleryCategories(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $galleryCategoryBuilder */
        $galleryCategoryBuilder = GalleryCategory::select([
            'gallery_categories.id',
            'gallery_categories.title_en',
            'gallery_categories.title_bn',
            'gallery_categories.institute_id',
            'gallery_categories.organization_id',
            'gallery_categories.programme_id',
            'gallery_categories.batch_id',
            'gallery_categories.featured',
            'gallery_categories.image',
            'gallery_categories.alt_title_en',
            'gallery_categories.alt_title_bn',
            'gallery_categories.featured',
            'gallery_categories.row_status',
            'gallery_categories.created_by',
            'gallery_categories.updated_by',
            'gallery_categories.created_at',
            'gallery_categories.updated_at'
        ]);

        $galleryCategoryBuilder->orderBy('gallery_categories.id', $order);

        if (is_numeric($rowStatus)) {
            $galleryCategoryBuilder->where('gallery_categories.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $galleryCategoryBuilder->where('gallery_categories.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $galleryCategoryBuilder->where('gallery_categories.title_bn', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $galleryCategories */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $galleryCategories = $galleryCategoryBuilder->paginate($pageSize);
            $paginateData = (object)$galleryCategories->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $galleryCategories = $galleryCategoryBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $galleryCategories->toArray()['data'] ?? $galleryCategories->toArray();
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
    public function getOneGalleryCategory(int $id, Carbon $startTime): array
    {
        /** @var Builder $galleryCategoryBuilder */
        $galleryCategoryBuilder = GalleryCategory::select([
            'gallery_categories.id',
            'gallery_categories.title_en',
            'gallery_categories.title_bn',
            'gallery_categories.institute_id',
            'gallery_categories.organization_id',
            'gallery_categories.programme_id',
            'gallery_categories.batch_id',
            'gallery_categories.image',
            'gallery_categories.alt_title_en',
            'gallery_categories.alt_title_bn',
            'gallery_categories.featured',
            'gallery_categories.row_status',
            'gallery_categories.created_by',
            'gallery_categories.updated_by',
            'gallery_categories.created_at',
            'gallery_categories.updated_at'
        ]);
        $galleryCategoryBuilder->where('gallery_categories.id', $id);

        /** @var GalleryCategory $galleryCategory */
        $galleryCategory = $galleryCategoryBuilder->first();

        return [
            "data" => $galleryCategory ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }


    /**
     * @param array $data
     * @return GalleryCategory
     */
    public function store(array $data): GalleryCategory
    {
        $galleryCategory = new GalleryCategory();
        $galleryCategory->fill($data);
        $galleryCategory->save();
        return $galleryCategory;
    }


    /**
     * @param GalleryCategory $galleryCategory
     * @param array $data
     * @return GalleryCategory
     */
    public function update(GalleryCategory $galleryCategory, array $data): GalleryCategory
    {
        $galleryCategory->fill($data);
        $galleryCategory->save();
        return $galleryCategory;
    }

    /**
     * @param GalleryCategory $galleryCategory
     * @return bool
     */
    public function destroy(GalleryCategory $galleryCategory): bool
    {
        return $galleryCategory->delete();
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
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
            ],
            'batch_id' => [
                'nullable',
                'int',
            ],
            'programme_id' => [
                'nullable',
                'int',
            ],
            'image' => [
                'nullable',
                'string',
                'string',
            ],
            'alt_title_en' => [
                'nullable',
                'string',
            ],

            'alt_title_bn' => [
                'nullable',
                'string',
            ],
            'featured' => [
                'nullable',
                'boolean'
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
            'title_bn' => 'nullable|min:500|min:2',
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
