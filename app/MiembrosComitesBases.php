<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiembrosComitesBases extends Model
{
    //

    protected $table = 'miembros_comites_bases';

    protected $fillable = [
        'votantes_id',
        'first_name',
        'last_name',
        'card_id',
        'address',
        'comite_base',
        'number_member',
    ];

    public function comites_bases()
    {
        return $this->belongsTo('App\CoordinadoresComitesBases', 'comite_base');
    }
}
