<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recintos extends Model
{
    //
    protected $table = "recintos";

    protected $fillable = [
        'municipios_id',
        'distritos_id',
        'name',
        'address'
    ];
    
    /**
     * distritos function
     *
     * @return Model
     */
    public function distritos()
    {
        return $this->belongsTo('App\Distritos');
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
