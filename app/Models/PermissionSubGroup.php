<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rules\Unique;

/**
 * Class PermissionSubGroup
 * @package App\Models
 * @property int $id
 * @property int $permission_group_id
 * @property string $title_en
 * @property string $title_bn
 * @property string|unique $key
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Permission[] $permissions
 */
class PermissionSubGroup extends BaseModel
{
    use ScopeRowStatusTrait,HasFactory;

    /**
     * @var string
     */
    protected $table = 'permission_sub_groups';
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_sub_group_permissions');
    }
}
