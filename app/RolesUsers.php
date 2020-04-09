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
        'entity',
    ];

    public $appends = ['entity_name'];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function roles()
    {
        return $this->belongsTo('App\Roles');
    }

    public function getEntityNameAttribute()
    {
        if ($this->entity != 'Admin') {
            $model = self::join($this->entity, 'roles_users.entity_id', '=', "{$this->entity}.id")
                ->select("{$this->entity}.*")
                ->first();

            return $model->name;
        } else {
            return " ";
        }

    }
}
