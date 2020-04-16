<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'votantes_id',
    ];

    public $timestamps = false;

    protected $appends = ['cedula'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Roles', 'roles_users', 'users_id', 'roles_id');
    }

    public function votantes()
    {
        return $this->belongsTo('App\Votantes'); //un usuario pertenece a una pertenece
    }

    public function getCedulaAttribute()
    {
        return ""; #$this->votantes->card_id;
    }

    public function canAction(string $permiso): bool
    {
        $roles = $this->roles ? $this->roles->toArray() : [];

        $roles = array_map(function ($rol) {
            return $rol['name'];
        }, $roles);

        if (in_array('Admin', $roles)) {
            return true;
        } elseif (in_array($permiso, $roles)) {
            return true;
        }

        return false;
    }

    public function hasRol($name): bool
    {
        $roles = $this->roles ? $this->roles->toArray() : [];

        $roles = array_map(function ($rol) {
            return $rol['name'];
        }, $roles);

        if (in_array($name, $roles)) {
            return true;
        }
        return false;
    }
    public function getEntitiesId(string $name): array
    {
        $entitiesId = self::join('roles_users', 'roles_users.users_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->where('roles.name', $name)
            ->where('roles_users.users_id', $this->id)
            ->select('roles_users.entity_id')
            ->get();

        $entitiesId = $entitiesId->toArray();
        $entitiesId = array_map(function ($entities) {
            return $entities['entity_id'];
        }, $entitiesId);

        return $entitiesId;
    }

}
