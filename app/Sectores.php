<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectores extends Model
{
    //
    protected $table = 'sectores';

    protected $fillable = [
        'name',
    ];
}
