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

    protected $foreignKey = 'colegios_electorales_id';

    protected $appends = ['number_votantes'];

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
    public function votantes()
    {
        return $this->hasMany('App\Votantes');
    }

    public function getNumberVotantesAttribute()
    {
        return $this->votantes->count();
    }

}
