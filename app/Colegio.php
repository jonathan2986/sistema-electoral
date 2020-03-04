<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colegio extends Model
{
    protected $fillable=[
        'provincia', 'municipio', 'distrito_municipal','circuscripcion'
    ];

    public function recinto_electorales(){
        return $this->hasMany('App\Recinto');//tiene varios recinto
    }
}
