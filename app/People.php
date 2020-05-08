<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class People extends Model
{
    //
    protected $table = 'people';
    use QueryCacheable;

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'circunscripciones_id',
        'municipios_id',
        'distritos_id',
        'recintos_id',
        'first_name',
        'last_name',
        'card_id',
        'phone_number',
        'celphone',
        'email',
        'date_birthdate',
        'profession',
        'colegios_electorales_id',
        'address',
        'sector',
        'sexo',
        'comites_bases_id',
        'confirmado',
    ];

    protected $appends = ['age', 'name'];

    public function getAgeAttribute()
    {
        $birthdate = new DateTime($this->date_birthdate);
        $currentDate = new DateTime(date('Y-m-d'));
        $interval = $birthdate->diff($currentDate);
        return $interval->y;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name} {$this->card_id}";
    }

    public function municipios()
    {
        return $this->belongsTo('App\Municipios');
    }

    public function provincias()
    {
        return $this->belongsTo('App\Provincias');
    }

    public function circunscripciones()
    {
        return $this->belongsTo('App\Circunscripciones');
    }

    public function distritos()
    {
        return $this->belongsTo('App\Distritos');
    }

    public function recintos()
    {
        return $this->belongsTo('App\Recintos');
    }

    public function colegios_electorales()
    {
        return $this->belongsTo('App\ColegiosElectorales');
    }

    public function comites_bases()
    {
        return $this->belongsTo('App\ComitesBases');
    }
}
