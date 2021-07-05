<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocUpazila extends BaseModel
{
    protected $table='loc_upazilas';
    protected $guarded=['id'];

    public function district(){
        return $this->belongsTo(LocDistrict::class,'loc_district_id');
    }
    public function division(){
        return $this->belongsTo(LocDivision::class,'loc_division_id');
    }
}
