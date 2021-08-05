<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;

/**
 * Class PermissionGroup
 * @package App\Models
 * @property int $id
 * @property int $row_status
 * @property string $title_en
 * @property string $title_bn
 * @property string $key
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PermissionGroup extends BaseModel
{
    use ScopeRowStatusTrait;

    protected $table = 'permission_groups';
    protected $guarded = ['id'];

}
