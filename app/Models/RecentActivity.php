<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class RecentActivity extends BaseModel
{
    use SoftDeletes;

    const CONTENT_TYPE_IMAGE = 1;
    const CONTENT_TYPE_VIDEO = 2;
    const CONTENT_TYPE_YOUTUBE =3;



    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;
    protected $table = 'recent_activities';
}
