<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocDistrict extends BaseModel
{
    protected $table='loc_districts';
    protected $guarded=['id'];

    public function division()
    {
        return $this->belongsTo(LocDivision::class,'loc_division_id');
    }
}
