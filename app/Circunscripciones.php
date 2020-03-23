<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circunscripciones extends Model
{
    use SoftDeletes;
    //
    protected $table = 'circunscripciones';

    protected $fillable = [
        'name',
    ];

    /**
     * municipios function
     *
     * @return void
     */
    public function municipios()
    {
       return $this->belongsTo('App\Municipios');
    }
}
