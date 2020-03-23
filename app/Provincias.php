<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model
{
    //
    protected $table = 'provincias';

    protected $fillable = [
        'name',
    ];
    
    /**
     * municipios
     *
     * @return Model
     */
    public function municipios()
    {
        $this->hasMany('App\Municipios', 'provincias_id');
    }
}
