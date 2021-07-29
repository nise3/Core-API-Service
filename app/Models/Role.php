<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * App\Models\Role
 *
 * @property int $id
 * @property string title_en
 * @property string title_bn
 * @property string description
 * @property string key
 * @property int $permission_group_id
 * @property int $organization_id
 * @property int $institute_id
 */
class Role extends BaseModel
{
    use ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }
}
