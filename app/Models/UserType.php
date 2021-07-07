<?php

namespace App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserType
 * @package App\Models\UserType
 * @property string title
 * @property string code
 * @property int row_status
 * @property int default_role_id
 * @property Role $role
 */
class UserType extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    const USER_TYPE_SUPER_USER_CODE = '1';
    const USER_TYPE_SYSTEM_USER_CODE = '2';
    const USER_TYPE_INSTITUTE_USER_CODE = '3';
    const USER_TYPE_ORGANIZATION_USER_CODE = '4';
    const USER_TYPE_DC_USER_CODE = '5';

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'default_role_id', 'id');
    }
}


