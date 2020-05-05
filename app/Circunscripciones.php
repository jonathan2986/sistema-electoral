<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Circunscripciones extends Model
{
    use SoftDeletes;
    use QueryCacheable;

    protected $cacheFor = 10800;
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
