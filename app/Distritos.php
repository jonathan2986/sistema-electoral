<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CoordinadorTrait;

class Distritos extends Model
{
    //
    use CoordinadorTrait;

    protected $table = 'distritos';

    protected $fillable = [
        'circunscripciones_id',
        'municipios_id',
        'name',
    ];

    protected $appends = ['recintos_number','coordinador'];

    protected $foreignKey = "distritos_id";

    protected $entity = 'distritos';

    protected $rolName = 'Coordinador de Distrito';

    /**
     * circunscripciones function
     *
     * @return Model
     */
    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
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

    public function recintos()
    {
        return $this->hasMany('App\Recintos');
    }

    public function getRecintosNumberAttribute()
    {
        return $this->recintos->count();
    }
    
}
