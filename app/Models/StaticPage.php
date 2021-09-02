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
    use HasFactory,SoftDeletes;

    const PAGE_ID_ABOUT_US = 'aboutus';

    protected $table = 'static_pages';
    protected $guarded = ['id'];

}
