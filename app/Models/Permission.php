<?php

namespace App\Models;

use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property date $created_at
 * @property date $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 */
class Permission extends BaseModel
{
    protected $guarded = ['id'];

    public function roles():hasMany
    {
        return $this->hasMany(Role::class);
    }




}
