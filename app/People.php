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
        'celphone',
        'email',
        'date_birthdate',
        'profession',
        'colegio_electoral',
        'address',
        'sector',
        'sexo',
        'municipios'
    ];

    protected $appends = ['age','name'];

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

}
