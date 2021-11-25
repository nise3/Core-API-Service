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

    public const COMMON_GUARDED_FIELDS_SIMPLE = ['id', 'created_at', 'updated_at'];
    public const COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE = ['id', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];
    public const COMMON_GUARDED_FIELDS_NON_SOFT_DELETE = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at'];


    public const WITH_PERMISSION_SUB_GROUP_TRUE = 1;
    public const WITH_PERMISSION_TRUE = 1;


    public const ROW_STATUS_INACTIVE = 0;
    public const ROW_STATUS_ACTIVE = 1;
    public const ROW_STATUS_PENDING = 2;
    public const ROW_STATUS_REJECT = 3;

    public const ROW_ORDER_ASC = 'ASC';
    public const ROW_ORDER_DESC = 'DESC';

    public const REQUIRED = 'REQUIRED';
    public const DUPLICATE = 'DUPLICATED';

    public const IN = "IN";

    public const ADMIN_CREATED_USER_DEFAULT_PASSWORD = "ABcd1234";

    public const PASSWORD_MIN_LENGTH = 8;
    public const PASSWORD_MAX_LENGTH = 20;

    /** Idp User */
    public const IDP_USERNAME = 'admin';
    public const IDP_USER_PASSWORD = 'Iadmin';

    /** Client Url End Point Type*/
    public const ORGANIZATION_CLIENT_URL_TYPE = "ORGANIZATION";
    public const INSTITUTE_URL_CLIENT_TYPE = "INSTITUTE";
    public const CORE_CLIENT_URL_TYPE = "CORE";
    public const IDP_SERVER_CLIENT_URL_TYPE = "IDP_SERVER";

    /**User Type*/
    public const SYSTEM_USER = 1;
    public const ORGANIZATION_USER = 2;
    public const INSTITUTE_USER = 3;
    public const YOUTH_USER_TYPE = 4;
    public const INDUSTRY_ASSOCIATION_TYPE = 5;

    /**User Types*/
    public const USER_TYPES = [
        self::SYSTEM_USER,
        self::ORGANIZATION_USER,
        self::INSTITUTE_USER,
        self::INDUSTRY_ASSOCIATION_TYPE
    ];

    public const USER_TYPE = [
        self::SYSTEM_USER => 'system',
        self::ORGANIZATION_USER => 'organization',
        self::INSTITUTE_USER => 'institute',
    ];

    public const MOBILE_REGEX = 'regex: /^(01[3-9]\d{8})$/';
    public const USERNAME_REGEX = 'regex: /^[a-zA-Z\_0-9]+$/';

    /** Service to service internal calling header type */
    public const DEFAULT_SERVICE_TO_SERVICE_CALL_KEY = 'service-to-service';
    public const DEFAULT_SERVICE_TO_SERVICE_CALL_FLAG_TRUE = true;
    public const DEFAULT_SERVICE_TO_SERVICE_CALL_FLAG_FALSE = false;
}
