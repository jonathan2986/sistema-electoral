<?php

namespace App\Http\Controllers;

use App\People;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    use CrudTrait;

    //
    public function __construct()
    {
        $this->model = new People;
    }

    public function store(Request $request)
    {
        $request = $request->toArray();
        if (strlen($request['card_id']) < 11) {
            return response()->json(['message' => 'Error, cedula invalida'], 404);
        }
        $data = $this->model::create($request);
        return response()->json($data);
    }
}
