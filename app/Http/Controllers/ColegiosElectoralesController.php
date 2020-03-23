<?php

namespace App\Http\Controllers;

use App\ColegiosElectorales;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class ColegiosElectoralesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new ColegiosElectorales;
    }
}
