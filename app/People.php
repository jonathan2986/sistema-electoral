<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    //
    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'last_name',
        'card_id',
        'phone_number',
        'email',
        'date_birthdate',
        'profession',
        'colegio_electoral',
        'address',
        'sector',
        'sexo',
    ];

    protected $appends = ['age', 'municipios','distritos'];

    public function getAgeAttribute()
    {
        $birthdate = new DateTime($this->date_birthdate);
        $currentDate = new DateTime(date('Y-m-d'));
        $interval = $birthdate->diff($currentDate);
        return $interval->y;
    }

    public function colegios_electorales()
    {
        return $this->belongsTo('App\ColegiosElectorales', 'colegio_electoral', 'name');
    }

    public function getMunicipiosAttribute()
    {
        $colegio = $this->colegios_electorales;
        if ($colegio) {
            $recinto = $colegio->recintos;
            $municipios = $recinto->municipios;
        }
        return $colegio ? $municipios->name : '';
    }

    public function getDistritosAttribute()
    {
        $colegio = $this->colegios_electorales;
        $distritos = '';
        if ($colegio) {
            $recinto = $colegio->recintos;
            $distritos = $recinto->distritos;
        }
        return $distritos ? $distritos->name : '';
    }
}
