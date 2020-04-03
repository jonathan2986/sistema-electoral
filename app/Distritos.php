<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distritos extends Model
{
    //

    protected $table = 'distritos';

    protected $fillable = [
        'circunscripciones_id',
        'municipios_id',
        'name',
    ];

    protected $appends = ['recintos_number','coordinador'];

    protected $foreignKey = "distritos_id";
    /**
     * circunscripciones function
     *
     * @return Model
     */
    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
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

    public function recintos()
    {
        return $this->hasMany('App\Recintos');
    }

    public function getRecintosNumberAttribute()
    {
        return $this->recintos->count();
    }
    
    public function getCoordinadorAttribute()
    {
        $coordinador = self::join('votantes', "{$this->table}.id",'=','votantes.'.$this->foreignKey)
                         ->join('users','votantes.id','=','users.votantes_id')
                         ->join('roles','roles.id','=','users.roles_id')
                         ->where('roles.name','Coordinador de Distrito')
                         ->where("votantes.{$this->foreignKey}", $this->id)
                         ->select('votantes.*')
                         ->first();

        return $coordinador ?  $coordinador->first_name. ' '.$coordinador->last_name : ' ';
    }
}
