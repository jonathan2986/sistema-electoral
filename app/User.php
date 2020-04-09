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


    public function votantes()
    {
        // return $this->belongsTo('App\Votantes'); //un usuario pertenece a una pertenece
    }

    public function getCedulaAttribute()
    {
        return "";  #$this->votantes->card_id;
    }

    public function canAction(string $permiso): bool
    {
        return 1 ;
    }
}
