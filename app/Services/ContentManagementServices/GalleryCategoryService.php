<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class GalleryCategoryService
{
    public function getAllGalleryCategories(array $request, Carbon $startTime)
    {
        $titleEn = array_key_exists('title_en', $request) ? $request['title_en'] : "";
        $titleBn = array_key_exists('title_bn', $request) ? $request['title_bn'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

        /** @var Builder $galleryCategoryBuilder */
        $galleryCategoryBuilder = GalleryCategory::acl()->select([
            'gallery_categories.id',
            'gallery_categories.title_en',
            'gallery_categories.title_bn',
            'gallery_categories.institute_id',
            'gallery_categories.programme_id',
            'gallery_categories.batch_id',
            'gallery_categories.featured',
            'gallery_categories.image',
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
        } elseif (!empty($titleBn)) {
            $galleryCategoryBuilder->where('gallery_categories.title_bn', 'like', '%' . $titleBn . '%');
        }
    }

}
