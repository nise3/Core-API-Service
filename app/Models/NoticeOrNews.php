<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * /**
 * App\Models\NoticeOrNews
 * @property int id
 * @property int type
 * @property int|null institute_id
 * @property int|null organization_id
 * @property string title_en
 * @property string title_bn
 * @property string |null description_en
 * @property string |null description_bn
 * @property string |null $image
 * @property string |null $file
 * @property string |null image_alt_title_en
 * @property string |null image_alt_title_bn
 * @property string |null file_alt_title_en
 * @property string |null file_alt_title_bn
 * @property int row_status
 * @property Carbon|null publish_date
 * @property Carbon|null archive_date
 * @property int |null created_by
 * @property int |null updated_by
 * @property Carbon |null created_at
 * @property Carbon |null updated_at
 *
 */
class NoticeOrNews extends BaseModel
{
    use SoftDeletes,HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    public const TYPE_NOTICE = 1;
    public const TYPE_NEWS = 2;

}
