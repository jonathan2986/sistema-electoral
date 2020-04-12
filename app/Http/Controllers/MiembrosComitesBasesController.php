<?php

namespace App\Http\Controllers;

use App\MiembrosComitesBases;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class MiembrosComitesBasesController extends Controller
{
    //
    use CrudTrait;
    public function __construct()
    {
        $this->model = new MiembrosComitesBases;
    }
}
