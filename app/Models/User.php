<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends AuthBaseModel
{

    protected $guarded = ['id'];

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
    ];


}
