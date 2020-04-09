<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesUsers extends Model
{
    //
    protected $table = 'roles_users';

    protected $fillable = [
        'users_id',
        'roles_id',
        'entity_id',
        'entity'
    ];
}
