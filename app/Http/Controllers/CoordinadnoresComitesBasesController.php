<?php

namespace App\Http\Controllers;
use Fredpeal\BakaHttp\Traits\CrudTrait;

use Illuminate\Http\Request;
use App\CoordinadoresComitesBases;

class CoordinadnoresComitesBasesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new CoordinadoresComitesBases;
    }
}
