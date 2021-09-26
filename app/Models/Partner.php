<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
class Partner extends Model
{

    protected $guarded=BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;

}
