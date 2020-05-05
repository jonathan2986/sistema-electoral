<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Provincias extends Model
{
    use SoftDeletes;
    use QueryCacheable;

    protected $cacheFor = 10800;
    //
    protected $table = 'provincias';

    protected $fillable = [
        'name',
    ];

    protected $appends = ['number_municipios'];

    /**
     * municipios
     *
     * @return Model
     */
    public function municipios()
    {
        return $this->hasMany('App\Municipios', 'provincias_id');
    }

    /**
     * getNumberMunicipiosAttribute function
     *
     * @return void
     */
    public function getNumberMunicipiosAttribute()
    {
        return $this->municipios->count();
    }
}
