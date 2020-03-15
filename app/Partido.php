<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $fillable = [
        'id', 'nombre_partido', 'siglas'
    ];

    public $timestamps = false;

    public function candidato(){
        return $this->hasMany('App\Candidato');//tiene varios candidatos
    }
}
