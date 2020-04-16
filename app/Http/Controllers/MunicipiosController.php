<?php

namespace App\Http\Controllers;

use App\Municipios;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use App\Provincias;
use Illuminate\Http\Request;

class MunicipiosController extends Controller
{
    use CrudTrait;
    //
    public function __construct()
    {
        $this->model = new Municipios;
    }

    public function searchByProvincias(Request $request, $provincia)
    {
        $provincias = Provincias::where('name', 'like', "%{$provincia}%")->select('id')->get();
        $provincias = $provincias->toArray();
        
        $provinciasId = array_map(function($provincia){
            return $provincia['id'];;
        }, $provincias);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'provincias_id',
            'value' => implode(',', $provinciasId)
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }
}
