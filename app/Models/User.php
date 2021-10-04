<?php

namespace App\Models;


use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

/**
 * Class User
 * @package App\Models
 * @property string name_en
 * @property string username
 * @property string name_bn
 * @property string email
 * @property string mobile
 * @property string profile_pic
 * @property int $role_id
 * @property int $user_type
 * @property int organization_id
 * @property int institute_id
 * @property int loc_division_id
 * @property int loc_district_id
 * @property int loc_upazila_id
 * @property int $row_status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Permission[] $permissions
 * @property-read Role[] $roles
 */
class User extends AuthBaseModel
{

    use ScopeRowStatusTrait, SoftDeletes, HasFactory;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SOFT_DELETE;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function setPasswordAttribute($pass)
    {

        $this->attributes['password'] = Hash::make($pass);

    }
}
