<?php

namespace App;

use App\Traits\CoordinadorTrait;
use Illuminate\Database\Eloquent\Model;

class Recintos extends Model
{
    //

    protected $table = "recintos";

    protected $fillable = [
        'municipios_id',
        'distritos_id',
        'name',
        'address',
        'coordinadores_id',
        'coordinadores_ejecutivos_id',
        'coordinadores_electorales_id',
        'coordinadores_seguridad_id',
        'coordinadores_finanzas_id',
    ];

    protected $entity = 'recintos';

    protected $rolName = 'Coordinador de Recinto';

    protected $appends = [
        'number_colegios',
    ];

    protected $foreignKey = 'recintos_id';

    /**
     * distritos function
     *
     * @return Model
     */
    public function distritos()
    {
        return $this->belongsTo('App\Distritos');
    }

    public function coordinadores()
    {
        return $this->belongsTo('App\Votantes', 'coordinadores_id', 'id');
    }

    public function coordinadores_ejecutivos()
    {
        return $this->belongsTo('App\Votantes', 'coordinadores_ejecutivos_id', 'id');
    }

    public function coordinadores_electorales()
    {
        return $this->belongsTo('App\Votantes', 'coordinadores_electorales_id', 'id');
    }

    public function coordinadores_seguridad()
    {
        return $this->belongsTo('App\Votantes', 'coordinadores_seguridad_id', 'id');
    }

    public function coordinadores_finanzas()
    {
        return $this->belongsTo('App\Votantes', 'coordinadores_finanzas_id', 'id');
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

    public function colegios_electorales()
    {
        return $this->hasMany('App\ColegiosElectorales');
    }

    public function getNumberColegiosAttribute()
    {
        return $this->colegios_electorales->count();
    }
}
