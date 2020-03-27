<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColegiosElectorales extends Model
{
    //
    protected $table = 'colegios_electorales';

    protected $fillable = [
        'recintos_id',
        'name',
    ];

    /**
     * municipios function
     *
     * @return Model
     */
    public function recintos()
    {
        return $this->belongsTo('App\Recintos');
    }

    /**
     * people function
     *
     * @return Model
     */
    public function people()
    {
        return $this->hasMany('App\People', 'colegio_electoral', 'name');
    }


}
