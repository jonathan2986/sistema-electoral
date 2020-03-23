<?php

namespace App\Http\Controllers;

use App\Recintos;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class RecintosController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Recintos;
    }
}
