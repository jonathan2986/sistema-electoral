<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColegioElectoral extends Model
{
    protected $table = 'colegios_electorales';
    protected $fillable =[
        'idrecinto','numero_colegio','cantidad_electores'
    ];

    public function recinto(){
        return $this->belongsTo('App\Recinto');//pertenece a un recinto
    }
    public function colegios_electorales(){
        return $this->hasMany('App\ColegioElectoral');//tiene varios colegios electorales
    }
    public function personas(){
        return $this->hasMany('App\Persona');//tiene varias personas
    }
    public function electores(){
        return $this->hasMany('App\Elector');//tiene varios electores
    }
}
