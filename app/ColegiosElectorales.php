<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColegiosElectorales extends Model
{
    //
    protected $table = 'colegios_electorales';

    protected $fillable = [
        'recintos_id',
        'name',
    ];

    protected $foreignKey = 'colegios_electorales_id';

    protected $appends = ['number_votantes','coordinador'];

    /**
     * municipios function
     *
     * @return Model
     */
    public function recintos()
    {
        return $this->belongsTo('App\Recintos');
    }

    /**
     * people function
     *
     * @return Model
     */
    public function votantes()
    {
        return $this->hasMany('App\Votantes');
    }

    public function getCoordinadorAttribute()
    {
        $coordinador = self::join('votantes', "{$this->table}.id",'=','votantes.'.$this->foreignKey)
                         ->join('users','votantes.id','=','users.votantes_id')
                         ->join('roles','roles.id','=','users.roles_id')
                         ->where('roles.name','Coordinador de Colegio')
                         ->where("votantes.{$this->foreignKey}", $this->id)
                         ->select('votantes.*')
                         ->first();

        return $coordinador ?  $coordinador->first_name. ' '.$coordinador->last_name : ' ';
    }

    public function getNumberVotantesAttribute()
    {
        return $this->votantes->count();
    }

}
