<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OrganizationPermissions
 *
 * @property int $id
 * @property int $organization_id
 * @property int $permission_id
 * @property bool $status
 * @property-read Permission $permission
 */
class OrganizationPermissions extends BaseModel
{
    public $timestamps = true;

    protected $table = 'organization_permissions';
    protected $fillable = ['organization_id', 'permission_id', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
}
