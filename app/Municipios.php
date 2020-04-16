<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CoordinadorTrait;

class Municipios extends Model
{

    use SoftDeletes;
    use CoordinadorTrait;

    //
    protected $table = 'municipios';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'circunscripciones_id',
        'provincias_id',
        'name',
    ];
    
    protected $appends = ['recintos_number', 'coordinador', 'distritos_number'];

    protected $foreignKey = 'municipios_id';

    protected $entity = 'municipios';

    protected $rolName = 'Coordinador de Municipio';

    /**
     * provincias
     *
     * @return void
     */
    public function provincias()
    {
       return $this->belongsTo('App\Provincias');
    }

    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
    }

    public function recintos()
    {
        return $this->hasMany('App\Recintos');
    }

    public function distritos()
    {
        return $this->hasMany('App\Distritos');
    }

    public function getRecintosNumberAttribute()
    {
        return $this->recintos->count();
    }

    public function getDistritosNumberAttribute()
    {
        return $this->distritos->count();
    }
}
