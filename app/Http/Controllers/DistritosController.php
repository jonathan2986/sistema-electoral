<?php

namespace App\Http\Controllers;

use App\Distritos;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class DistritosController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Distritos;
    }
}
