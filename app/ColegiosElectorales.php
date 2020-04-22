<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CoordinadorTrait;

class ColegiosElectorales extends Model
{
    //
    protected $table = 'colegios_electorales';

    protected $fillable = [
        'recintos_id',
        'name',
        'coordinadores_id'
    ];

    protected $foreignKey = 'colegios_electorales_id';

    protected $appends = ['number_votantes'];

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

    public function coordinadores()
    {
        return $this->belongsTo('App\People', 'coordinadores_id', 'id');
    }
    
    /**
     * people function
     *
     * @return Model
     */
    public function votantes()
    {
        return $this->hasMany('App\People');
    }

    public function getNumberVotantesAttribute()
    {
        return $this->votantes->count();
    }

}
