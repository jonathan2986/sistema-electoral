<?php

namespace App\Http\Controllers;

use App\RolesUsers;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class RolesUsersController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new RolesUsers;
    }
}
