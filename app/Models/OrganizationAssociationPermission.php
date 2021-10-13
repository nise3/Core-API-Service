<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationAssociationPermission extends BaseModel
{
    public $timestamps = false;

    protected $table = 'organization_association_permissions';
    protected $fillable = ['organization_association_id', 'permission_id'];

    public function permissions(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
