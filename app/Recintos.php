<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Recintos extends Model
{
    //
    use QueryCacheable;

    protected $cacheFor = 10800;
    protected $table = "recintos";
    protected static $flushCacheOnUpdate = true;

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
        'activistas_id',
        'activistas1_id',
        'activistas2_id',
        'activistas3_id',
        'activistas4_id',
        'activistas5_id',
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
        return $this->belongsTo('App\People', 'coordinadores_id', 'id');
    }

    public function coordinadores_ejecutivos()
    {
        return $this->belongsTo('App\People', 'coordinadores_ejecutivos_id', 'id');
    }

    public function coordinadores_electorales()
    {
        return $this->belongsTo('App\People', 'coordinadores_electorales_id', 'id');
    }

    public function coordinadores_seguridad()
    {
        return $this->belongsTo('App\People', 'coordinadores_seguridad_id', 'id');
    }

    public function coordinadores_finanzas()
    {
        return $this->belongsTo('App\People', 'coordinadores_finanzas_id', 'id');
    }

    public function activistas()
    {
        return $this->belongsTo('App\People', 'activistas_id', 'id');
    }

    public function activistas1()
    {
        return $this->belongsTo('App\People', 'activistas1_id', 'id');
    }

    public function activistas2()
    {
        return $this->belongsTo('App\People', 'activistas2_id', 'id');
    }

    public function activistas3()
    {
        return $this->belongsTo('App\People', 'activistas3_id', 'id');
    }

    public function activistas4()
    {
        return $this->belongsTo('App\People', 'activistas4_id', 'id');
    }

    public function activistas5()
    {
        return $this->belongsTo('App\People', 'activistas5_id', 'id');
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
