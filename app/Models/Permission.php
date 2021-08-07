<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Models\Permission
 *
 * @property int $id
 * @property int $method // possible values : 1, 2, 3, 4, 5, 6
 * @property int $row_status
 * @property string $uri
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Role[] $roles
 */
class Permission extends BaseModel
{
    use ScopeRowStatusTrait;

    public const METHOD_GET = 1;
    public const METHOD_POST = 2;
    public const METHOD_PUT = 3;
    public const METHOD_PATCH = 4;
    public const METHOD_DELETE = 5;

    protected $guarded = ['id'];

    public function roles():hasMany
    {
        return $this->hasMany(Role::class);
    }




}
