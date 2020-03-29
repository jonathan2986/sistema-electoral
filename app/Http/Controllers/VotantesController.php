<?php

namespace App\Http\Controllers;

use App\Votantes;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class VotantesController extends Controller
{
    //
    use CrudTrait;

    //
    public function __construct()
    {
        $this->model = new Votantes;
    }
}
