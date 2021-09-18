<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *App\Models\Model
 * @property int $id
 * @property string name
 */
class Menu extends BaseModel
{
    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }


}
