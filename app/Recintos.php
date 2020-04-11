<?php

namespace App;

use App\Traits\CoordinadorTrait;
use Illuminate\Database\Eloquent\Model;

class Recintos extends Model
{
    //
    use CoordinadorTrait;

    protected $table = "recintos";

    protected $fillable = [
        'municipios_id',
        'distritos_id',
        'name',
        'address',
    ];

    protected $entity = 'recintos';

    protected $rolName = 'Coordinador de Recinto';

    protected $appends = [
        'number_colegios',
        'coordinador',
        'coordinador_ejecutivo',
        'coordinador_electoral',
        'coordinador_seguridad',
        'coordinador_finanza',
    ];

    protected $foreignKey = 'recintos_id';

    /**
     * distritos function
     *
     * @return Model
     */
    public function distritos()
    {
        return $this->belongsTo('App\Distritos');
    }

    /**
     * municipios function
     *
     * @return Model
     */
    public function municipios()
    {
        return $this->belongsTo('App\Municipios');
    }

    public function colegios_electorales()
    {
        return $this->hasMany('App\ColegiosElectorales');
    }

    public function getNumberColegiosAttribute()
    {
        return $this->colegios_electorales->count();
    }

    public function getCoordinadorEjecutivoAttribute()
    {
        $coordiandor = \App\Votantes::join('users', 'users.votantes_id', '=', 'votantes.id')
            ->join('roles_users', 'roles_users.users_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->where('roles_users.entity', $this->entity)
            ->where('roles_users.entity_id', $this->id)
            ->where('roles.name', 'Ejecutivo')
            ->select('votantes.*')
            ->first();

        return $coordiandor ? $coordiandor->fist_name . ' ' . $coordiandor->last_name : ' ';
    }

    public function getCoordinadorElectoralAttribute()
    {
        $coordiandor = \App\Votantes::join('users', 'users.votantes_id', '=', 'votantes.id')
            ->join('roles_users', 'roles_users.users_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->where('roles_users.entity', $this->entity)
            ->where('roles_users.entity_id', $this->id)
            ->where('roles.name', 'Electoral')
            ->select('votantes.*')
            ->first();

        return $coordiandor ? $coordiandor->fist_name . ' ' . $coordiandor->last_name : ' ';
    }

    public function getCoordinadorFinanzaAttribute()
    {
        $coordiandor = \App\Votantes::join('users', 'users.votantes_id', '=', 'votantes.id')
            ->join('roles_users', 'roles_users.users_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->where('roles_users.entity', $this->entity)
            ->where('roles_users.entity_id', $this->id)
            ->where('roles.name', 'Finanza')
            ->select('votantes.*')
            ->first();

        return $coordiandor ? $coordiandor->fist_name . ' ' . $coordiandor->last_name : ' ';
    }

    public function getCoordinadorSeguridadAttribute()
    {
        $coordiandor = \App\Votantes::join('users', 'users.votantes_id', '=', 'votantes.id')
            ->join('roles_users', 'roles_users.users_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'roles_users.roles_id')
            ->where('roles_users.entity', $this->entity)
            ->where('roles_users.entity_id', $this->id)
            ->where('roles.name', 'Seguridad')
            ->select('votantes.*')
            ->first();

        return $coordiandor ? $coordiandor->fist_name . ' ' . $coordiandor->last_name : ' ';
    }
}
