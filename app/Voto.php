<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $table = 'votos';

    protected $fillable = [
        'idcandidato','idpartido','voto_candidato','voto_nulo','votos_valido','boletas_observada','total_voto'
    ];
    public $timestamps = false;

    public function candidato(){
        return $this->belongsTo('App\Candidato');//pertenece a un candidato
    }
}
