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
        'code',
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

}
