<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

/**
 * Class LocDivision
 * @package App\Models
 *
 * @property int $id
 * @property string $title_bn
 * @property string|null $title_en
 * @property string|null $bbs_code
 * @property int |null $created_by
 * @property int |null $updated_by
 * @property int $row_status
 * @property date $created_at
 * @property date $updated_at
 * @property-read Collection|\App\Models\LocUpazila[] $locUpazilas
 * @property-read Collection|\App\Models\LocDistrict[] $locDistricts
 */
class LocDivision extends BaseModel
{
    protected $table = 'loc_divisions';
    protected $guarded = ['id'];

    public function locUpazilas(): HasMany
    {
        return $this->hasMany(LocUpazila::class, 'loc_district_id');
    }

    public function locDistricts():HasMany
    {
        return $this->hasMany(LocDistrict::class, 'loc_district_id');
    }

}
