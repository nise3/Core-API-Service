<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Institute
 * @package App\Models
 * @property string title_en
 * @property string|null title_bn
 * @property string code
 * @property string domain
 * @property string|null address
 * @property string|null google_map_src
 * @property string logo
 * @property string|null config
   v@property int role_id
 */
class Institute extends BaseModel
{

    protected $guarded = ['id'];

    protected $casts = [
        'phone_numbers' => 'array',
        'mobile_numbers' => 'array',
    ];
}
