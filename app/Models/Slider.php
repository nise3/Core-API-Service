<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Slider
 * @package App\Models
 * @property int institute_id
 * @property string title
 * @property string sub_title
 * @property string description
 * @property string link
 * @property int is_button_available
 * @property string button_text
 * @property string slider
 * @property int row_status
 */
class Slider extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'slider_images' => 'array',
    ];
    protected $guarded = ['id'];


    public const IS_BUTTON_AVAILABLE_YES = 1;
    public const IS_BUTTON_AVAILABLE_NO = 0;

}
