<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectores extends Model
{
    //
    protected $table = 'sectores';

    protected $fillable = [
        'name',
        'municipios_id',
        'recintos_id',
        'distritos_id',
    ];

    public function municipios()
    {
        return $this->belongsTo('App\Municipios');
    }

    public function distritos()
    {
        return $this->belongsTo('App\Distritos');
    }
}
