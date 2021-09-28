<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PermissionGroup
 * @package App\Models
 * @property int $id
 * @property int $row_status
 * @property string $title_en
 * @property string $title_bn
 * @property string $key
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */



class PermissionGroup extends BaseModel
{
    use ScopeRowStatusTrait, HasFactory;

    protected $table = 'permission_groups';
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_group_permissions');
    }

    public function permissionSubGroup(): HasMany
    {
        return $this->hasMany(PermissionSubGroup::class);
    }

}
