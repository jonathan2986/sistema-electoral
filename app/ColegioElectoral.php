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
        return $this->belongsTo('App\Recinto');//pertenece a un colegio
    }
    public function colegios_electorales(){
        return $this->hasMany('App\ColegioElectoral');//tiene varios colegios electorales
    }
}
