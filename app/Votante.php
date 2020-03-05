<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Votante extends Model
{
    protected $table = 'votantes';
    protected $fillable = [
        'id', 'nombre_votante', 'cedula','telefono','voto_simpatizantes'
    ];

    public function persona()
    {
        return $this->belongsTo('App\Persona');//pertenece a una persona
    }
}
