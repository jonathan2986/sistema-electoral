<?php

namespace App\Http\Controllers;

use App\Provincias;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class ProvinciasController extends Controller
{
    //
    use CrudTrait;    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Provincias;
    }
}
