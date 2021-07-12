<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Models\InstitutePermissions
 *
 * @property int $id
 * @property int $institute_id
 * @property int $permission_id
 * @property bool $status
 * @property-read Permission $permission
 */
class InstitutePermissions extends BaseModel
{
    public $timestamps = true;

    protected $table = 'institute_permissions';
    protected $fillable = ['institute_id', 'permission_id', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
}
