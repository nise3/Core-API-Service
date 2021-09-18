<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\MenuItem
 * @property int $id
 * @property string title
 * @property string title_lang_key
 * @property string permission_key
 * @property string url
 * @property string target
 * @property string icon_class
 * @property string color
 * @property int parent_id
 * @property int order
 * @property string route
 * @property string parameters
 */
class MenuItem extends BaseModel
{
    protected $guarded = ['id'];

    public function menu()
    {
        $this->belongsTo(Menu::Class);
    }
    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
