<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Models\InstitutePermissions
 *
 *
 * @property int $institute_id
 * @property int $permission_id
 *
 * @property-read Permission $permissions
 */
class InstitutePermissions extends BaseModel
{
    public $timestamps = false;

    protected $table = 'institute_permissions';
    protected $fillable = ['institute_id', 'permission_id'];

    public function permissions(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
