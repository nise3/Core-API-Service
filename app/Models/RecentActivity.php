<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RecentActivity
 * @package App\Models
 * @property int id
 * @property string|null title_en
 * @property string|null title_bn
 * @property int|null institute_id
 * @property int|null organization_id
 * @property string|null description_en
 * @property int content_type
 * @property string|null content_path
 * @property string|null content_properties
 * @property string|null alt_title_en
 * @property string|null alt_title_bn
 * @property Carbon publish_date
 * @property Carbon archive_date
 * @property int row_status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class RecentActivity extends BaseModel
{
    use SoftDeletes,HasFactory;

    const CONTENT_TYPE_IMAGE = 1;
    const CONTENT_TYPE_VIDEO = 2;
    const CONTENT_TYPE_YOUTUBE = 3;


    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    protected $table = 'recent_activities';
}
