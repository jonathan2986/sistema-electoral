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
    ];

    public $appends = ['members_count'];
    public function votantes()
    {
        return $this->belongsTo('App\Votantes');
    }

    public function miembros()
    {
        return $this->hasMany('App\Votantes', 'comites_bases_id', 'id');
    }

    public function getMembersCountAttribute()
    {
        return $this->miembros ? $this->miembros->count() : 0;
    }
}
