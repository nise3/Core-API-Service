<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LocDistrict
 * @package App\Models
 *
 * @property int $id
 * @property string $title_bn
 * @property string|null $title_en
 * @property string|null $bbs_code
 * @property string|null $division_bbs_code
 * @property int $loc_division_id
 * @property bool|null $is_sadar_district
 * @property-read Collection|\App\Models\LocUpazila[] $locUpazilas
 * @property-read LocDivision locDivision
 * @property int |null $created_by
 * @property int |null $updated_by
 */
class LocDistrict extends BaseModel
{
    use ScopeRowStatusTrait;

    protected $table = 'loc_districts';
    protected $guarded = ['id'];

    public function locDivision(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'loc_division_id');
    }

    public function locUpazilas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LocUpazila::class, 'loc_district_id');
    }
}
