<?php

namespace App\Models;


use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Gallery
 * @package Module\CourseManagement\App\Models
 * @property int content_type
 * @property int institute_id
 * @property int gallery_category_id
 * @property string content_title
 * @property string content_path
 * @property int is_youtube_video
 * @property Carbon publish_date
 * @property Carbon archive_date
 * @property string you_tube_video_id
 * @property-read GalleryCategory galleryCategory
 */
class Gallery extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes, HasFactory;

    protected $guarded = ['id'];

    const CONTENT_TYPE_IMAGE = 1;
    const CONTENT_TYPE_VIDEO = 2;

    const IS_YOUTUBE_VIDEO_YES = 1;
    const IS_YOUTUBE_VIDEO_NO = 0;


    public function galleryCategory(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class);
    }

}
