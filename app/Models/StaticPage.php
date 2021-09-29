<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StaticPage
 * @package App\Models
 * @property int institute_id
 * @property string title_en
 * @property string title_bn
 * @property string page_id
 * @property string page_contents
 * @property int row_status
 */
class StaticPage extends BaseModel
{
    use HasFactory, SoftDeletes;

    const TYPE_BLOCK = 1;
    const TYPE_STATIC_PAGE = 2;

    const CONTENT_TYPE_IMAGE = 1;
    const CONTENT_TYPE_VIDEO = 2;
    const CONTENT_TYPE_YOUTUBE = 3;


    protected $table = 'static_pages_and_block';
    protected $guarded = ['id'];

}
