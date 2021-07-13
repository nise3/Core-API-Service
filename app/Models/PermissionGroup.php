<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionGroup
 * @package App\Models
 * @property int $id
 * @property string| $name
 * @property int|null $organization_id
 * @property int|null $institute_id
 * @property Permission $permissions
 */
class PermissionGroup extends Model
{

    protected $table='permission_groups';
    protected $guarded=['id'];

    public function permissions() {

        return $this->belongsToMany(Permission::class,'permission_group_permissions');

    }
}
