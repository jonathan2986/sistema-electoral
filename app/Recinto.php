<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recinto extends Model
{
    protected $table = 'recinto_electoral';
    protected $fillable =[
        'idcolegio','nombre_recinto','direccion'
    ];
    public function colegio(){
        return $this->belongsTo('App\Colegio');//pertenece a un colegio
    }
}
