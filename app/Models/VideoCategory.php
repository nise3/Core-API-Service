<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VideoCategory
 * @package App\Models
 * @property int institute_id
 * @property int|null parent_id
 * @property string title_en
 * @property string title_bn
 * @property int row_status
 */
class VideoCategory extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function videos(): HasMany
    {

        return $this->hasMany(Video::class);
    }
}
