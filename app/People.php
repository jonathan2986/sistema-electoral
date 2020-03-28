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
    ];
    
    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        $birthdate = new DateTime($this->date_birthdate);
        $currentDate = new DateTime(date('Y-m-d'));
        $interval = $birthdate->diff($currentDate);
        return $interval->y;

    }
}
