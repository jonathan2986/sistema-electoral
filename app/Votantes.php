<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Votantes extends Model
{
    //
    protected $table = 'votantes';

    protected $fillable = [
        'people_id',
        'circunscripciones_id',
        'municipios_id',
        'distritos_id',
        'recintos_id',
        'colegios_electorales_id',
        'first_name',
        'last_name',
        'card_id',
    ];

    public function people()
    {
        return $this->belongsTo('App\People');
    }

    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
    }

    public function municipios()
    {
        return $this->belongsTo('App\Municipios');
    }

    public function distritos()
    {
        return $this->belongsTo('App\Distritos');
    }

    public function recintos()
    {
        return $this->belongsTo('App\Recintos');
    }

    public function colegios_electorales()
    {
        return $this->belongsTo('App\ColegiosElectorales');
    }
}
