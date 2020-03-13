<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['idcolegio_electoral','nombre','apellido','cedula','direccion','email','telefono','voto'];

    public function elector(){
        return $this->hasOne('App\Elector');//una persona esta relacionada de manera directa con un votante
    }
    public function colegioElectoral(){
        return $this->belongsTo('App\ColegioElectoral');//pertenece a un colegio electoral
    }

    public function user(){
        return $this->hasOne('App\User');//esta relacionada de manera directa o tiene un usuario
    }
}
