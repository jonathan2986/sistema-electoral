<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipios extends Model
{

    use SoftDeletes;

    //
    protected $table = 'municipios';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'circunscripciones_id',
        'provincias_id',
        'name',
    ];
    
    /**
     * provincias
     *
     * @return void
     */
    public function provincias()
    {
       return $this->belongsTo('App\Provincias');
    }

    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
    }
}
