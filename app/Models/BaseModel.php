<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    protected $hidden = ['pivot'];

    public const ROW_STATUS_ACTIVE = '1';
    public const ROW_STATUS_INACTIVE = '0';

    public const ROW_ORDER_ASC = 'ASC';
    public const ROW_ORDER_DESC = 'DESC';

    public const REQUIRED = 'REQUIRED';
    public const DUPLICATE = 'DUPLICATED';

    public const IN = "IN";

    public const COMMON_GUARDED_FIELDS_SIMPLE = ['id', 'created_at', 'updated_at'];
    public const COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE = ['id', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_NON_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    /** Idp User */
    public const IDP_USERNAME = 'admin';
    public const IDP_USER_PASSWORD = 'admin';
    public const IDP_USER_CREATE_ENDPOINT = 'https://identity.bus.softbd.xyz/scim2/Users';



    /**User Type*/
    public const SYSTEM_USER = 1;
    public const ORGANIZATION_USER =2;
    public const INSTITUTE_USER = 3;

    /** System Admin Role Key */
    public const SYSTEM_USER_ROLE_KEY='system_user';

    public const USER_TYPE = [
        self::SYSTEM_USER => 'system',
        self::ORGANIZATION_USER => 'organization',
        self::INSTITUTE_USER => 'institute',
    ];
}
