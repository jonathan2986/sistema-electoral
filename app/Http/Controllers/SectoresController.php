<?php

namespace App\Http\Controllers;

use App\Sectores;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class SectoresController extends Controller
{
    //
    use CrudTrait;

    //
    public function __construct()
    {
        $this->model = new Sectores;
    }
}
