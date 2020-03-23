<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincias extends Model
{
    use SoftDeletes;
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
