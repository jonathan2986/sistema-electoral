<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComitesBases extends Model
{
    //
    protected $table = 'comites_bases';

    protected $fillable = [
        'people_id',
        'name',
    ];

    public function people()
    {
        return $this->belongsTo('App\People');
    }

    public function miembros()
    {
        return $this->hasMany('App\People');
    }
}
