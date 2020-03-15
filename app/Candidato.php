<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable =[
        'idpartido','nombre_candidato','tipo_candidatura'
    ];

    public $timestamps = false;
    
    public function partido(){
        return $this->belongsTo('App\Partido');//pertenece a un partido
    }

    public function votos(){
        return $this->hasMany('App\Voto');//tiene muchos votos
    }
}
