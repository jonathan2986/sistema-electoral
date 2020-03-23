<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distritos extends Model
{
    //

    protected $table = 'distritos';

    protected $fillable = [
        'circunscripciones_id',
        'municipios_id',
        'name',
    ];
    
    /**
     * circunscripciones function
     *
     * @return Model
     */
    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
    }
    
    /**
     * municipios function
     *
     * @return Model
     */
    public function municipios()
    {
        return $this->belongsTo('App\Municipios');
    }
}
