<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Role
 *
 * @property int $id
 * @property string title_en
 * @property string title
 * @property string description
 * @property string key
 * @property int $permission_group_id
 * @property int $permission_sub_group_id
 * @property int $organization_id
 * @property int $institute_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Permission[] $permissions
 */
class Role extends BaseModel
{
    use ScopeRowStatusTrait, SoftDeletes, HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;



    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
