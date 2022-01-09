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
 * @property string idp_user_id
 * @property string name
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
 * @property int industry_association_id
 * @property int branch_id
 * @property int training_center_id
 * @property int $row_status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Permission[] $permissions
 * @property-read Role $role
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
        'verification_code_sent_at' => 'datetime',
        'verification_code_verified_at' => 'datetime',
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

    public function isSystemUser(): bool
    {
        return $this->user_type == BaseModel::SYSTEM_USER;
    }

    public function isOrganizationUser(): bool
    {
        return $this->user_type == BaseModel::ORGANIZATION_USER && $this->organization_id;
    }

    public function isInstituteUser(): bool
    {
        return $this->user_type == BaseModel::INSTITUTE_USER && $this->institute_id;
    }

    public function isIndustryAssociationUser(): bool
    {
        return $this->user_type == BaseModel::INDUSTRY_ASSOCIATION_USER && $this->industry_association_id;
    }
}
