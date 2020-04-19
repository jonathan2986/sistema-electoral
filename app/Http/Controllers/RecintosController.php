<?php

namespace App\Http\Controllers;

use App\Recintos;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;
use App\Distritos;
use App\Municipios;

class RecintosController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Recintos;
    }


    public function getByDistritos(Request $request, $name)
    {
        $distritos = Distritos::where('name', 'like', "%{$name}%")->select('id')->get();
        $distritos = $distritos->toArray();
        
        $distritosId = array_map(function($distrito){
            return $distrito['id'];;
        }, $distritos);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'distritos_id',
            'value' => implode(',', $distritosId)
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }


    public function getByMunicipios(Request $request, $name)
    {
        $municipios = Municipios::where('name', 'like', "%{$name}%")->select('id')->get();
        $municipios = $municipios->toArray();
        
        $municipiosId = array_map(function($municipio){
            return $municipio['id'];;
        }, $municipios);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'municipios_id',
            'value' => implode(',', $municipiosId)
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }
}
