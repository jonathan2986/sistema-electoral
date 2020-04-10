<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CoordinadorTrait;

class ColegiosElectorales extends Model
{
    //
    use CoordinadorTrait;

    protected $table = 'colegios_electorales';

    protected $fillable = [
        'recintos_id',
        'name',
    ];

    protected $foreignKey = 'colegios_electorales_id';

    protected $appends = ['number_votantes', 'coordinador'];

    protected $entity = 'colegios_electorales';

    protected $rolName = 'Coordinador de Colegio';

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
