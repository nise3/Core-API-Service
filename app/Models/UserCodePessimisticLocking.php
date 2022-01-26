<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCodePessimisticLocking extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'last_incremental_value';
    protected $casts = [
        "last_incremental_value" => "integer"
    ];

}
