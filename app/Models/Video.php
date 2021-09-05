<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Video
 * @package App\Models
 * @property int institute_id
 * @property int video_category_id
 * @property string title_en
 * @property string title_bn
 * @property string|null description
 * @property int video_type 1 => youtube video 2 => uploaded video
 * @property string|null youtube_video_id
 * @property string|null youtube_video_url
 * @property string|null uploaded_video_path
 * @property int row_status
 */
class Video extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    const VIDEO_TYPE_YOUTUBE_VIDEO = 1;
    const VIDEO_TYPE_UPLOADED_VIDEO = 2;

    public function videoCategory(): belongsTo
    {
        return $this->belongsTo(VideoCategory::class);
    }


}
