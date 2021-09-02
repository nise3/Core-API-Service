<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    public const ROW_STATUS_ACTIVE = '1';
    public const ROW_STATUS_INACTIVE = '0';
    public const ROW_ORDER_ASC='ASC';
    public const ROW_ORDER_DESC='DESC';
    public const REQUIRED='REQUIRED';
    public const DUPLICATE='DUPLICATED';
    public const IN="IN";

}
