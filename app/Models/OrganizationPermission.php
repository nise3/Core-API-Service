<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OrganizationPermission
 * @property int $organization_id
 * @property int $permission_id
 * @property-read Permission $permissions
 */
class OrganizationPermission extends BaseModel
{
    public $timestamps = false;

    protected $table = 'organization_permissions';

    protected $fillable = ['organization_id', 'permission_id'];

    public function permissions(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
