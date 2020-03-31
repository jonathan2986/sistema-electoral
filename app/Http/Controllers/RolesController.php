<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use App\Roles;

class RolesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Roles;
    }
}
