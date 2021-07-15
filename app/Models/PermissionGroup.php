<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Collection\Collection;

/**
 * Class PermissionGroup
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int|null $organization_id
 * @property int|null $institute_id
 * @property Collection | Permission[] $permissions
 */
class PermissionGroup extends BaseModel
{

    protected $table = 'permission_groups';
    protected $guarded = ['id'];

    public function permissions(): BelongsToMany
    {

        return $this->belongsToMany(Permission::class, 'permission_group_permissions');

    }
}
