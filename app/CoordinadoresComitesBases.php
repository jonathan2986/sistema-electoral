<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoordinadoresComitesBases extends Model
{
    //
    protected $table = 'coordinadores_comites_bases';

    protected $fillable = [
        'votantes_id',
        'first_name',
        'last_name',
        'card_id',
        'address',
        'comite_base',
        'number_member',
    ];

    public function votantes()
    {
        return $this->belongsTo('App\Votantes');
    }
}
