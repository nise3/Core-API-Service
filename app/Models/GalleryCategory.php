<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class GalleryCategory
 * @package App\Models
 *
 * @property int $id
 * @property string title_en
 * @property string title_bn
 * @property string image
 * @property bool featured
 * @property int row_status
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property int institute_id
 * @property int|null programme_id
 * @property int|null batch_id
 */
class GalleryCategory extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes,HasFactory;

    protected $guarded = ['id'];


    /**
     * @return HasMany
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
