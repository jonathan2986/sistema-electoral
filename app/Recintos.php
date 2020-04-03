<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recintos extends Model
{
    //
    protected $table = "recintos";

    protected $fillable = [
        'municipios_id',
        'distritos_id',
        'name',
        'address'
    ];
    
    protected $appends = ['number_colegios','coordinador'];

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

    public function getCoordinadorAttribute()
    {
        $coordinador = self::join('votantes', "{$this->table}.id",'=','votantes.'.$this->foreignKey)
                         ->join('users','votantes.id','=','users.votantes_id')
                         ->join('roles','roles.id','=','users.roles_id')
                         ->where('roles.name','Coordinador de Recinto')
                         ->where("votantes.{$this->foreignKey}", $this->id)
                         ->select('votantes.*')
                         ->first();

        return $coordinador ?  $coordinador->first_name. ' '.$coordinador->last_name : ' ';
    }
}
