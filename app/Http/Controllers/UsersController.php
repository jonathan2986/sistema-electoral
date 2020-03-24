<?php

namespace App\Http\Controllers;

use App\User;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new User;
    }

    public function store(Request $request)
    {
        $request = $request->toArray();
        $request['password'] = bcrypt($request['password']);
        $data = $this->model::create($request);
        return response()->json($data);
    }
}
