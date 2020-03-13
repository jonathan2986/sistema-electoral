<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elector extends Model
{
    protected $table = 'electores';
    protected $fillable = [
        'idcolegio_electoral',
        'idusuario',
        'idpersona',
        'votoComputado'
    ];


    public function usuario(){
        return $this->belongsTo('App\User');//pertenece a un usuario
    }

    public function persona(){
        return $this->belongsTo('App\Persona');//pertenece a un usuario
    }

    public function colegioElectoral(){
        return $this->belongsTo('App\ColegioElectoral');//pertenece a un colegio electoral
    }
}
