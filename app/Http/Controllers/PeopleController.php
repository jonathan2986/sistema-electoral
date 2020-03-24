<?php

namespace App\Http\Controllers;

use App\People;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class PeopleController extends Controller
{
    use CrudTrait;

    //
    public function __construct()
    {
        $this->model = new People;
    }
}
