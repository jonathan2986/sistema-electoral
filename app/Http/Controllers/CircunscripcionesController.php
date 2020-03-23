<?php

namespace App\Http\Controllers;

use App\Circunscripciones;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class CircunscripcionesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Circunscripciones;
    }
}
