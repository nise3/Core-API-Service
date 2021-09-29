<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Partner
 * @property int $id
 * @property string $title_en
 * @property string $title_bn
 * @property string |null $image
 * @property string |null $domain
 * @property string |null $alt_title_en
 * @property string |null $alt_title_bn
 * @property int |null $created_by
 * @property int |null $updated_by
 * @property Carbon |null $created_at
 * @property Carbon |null $updated_at
 * @property-read Permission $permissions
 */
class Partner extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes, HasFactory;

    protected $guarded=BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;

}
