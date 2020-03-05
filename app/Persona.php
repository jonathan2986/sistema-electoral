<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['idcolegio_electoral','nombre','apellido','cedula','direccion','email','telefono','voto'];

    public function votante(){
        return $this->hasOne('App\Votante');//una persona esta relacionada de manera directa con un votante
    }
    public function colegioElectoral(){
        return $this->belongsTo('App\ColegioElectoral');//pertenece a un colegio electoral
    }
}
