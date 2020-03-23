<?php

namespace App\Http\Controllers;

use App\Municipios;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class MunicipiosController extends Controller
{
    use CrudTrait;
    //
    public function __construct()
    {
        $this->model = new Municipios;
    }
}
