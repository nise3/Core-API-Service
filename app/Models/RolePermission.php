<?php

namespace App\Models;


/**
 * Class RolePermission
 * @package App\Models
 * @property int $id
 * @property int role_id
 * @property int permission_id
 */
class RolePermission extends BaseModel
{
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'role_permissions';

    /**
     * @var string[]
     */
    protected $fillable = ['role_id', 'permission_id'];
}
