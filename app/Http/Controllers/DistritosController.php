<?php

namespace App\Http\Controllers;

use App\Distritos;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;
use App\Municipios;
use App\Circunscripciones;

class DistritosController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Distritos;
    }

    public function getByMunicipios(Request $request, $municipio)
    {
        $municipios = Municipios::where('name', 'like', "%{$municipio}%")->select('id')->get();
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

    public function getByCircunscripciones(Request $request, $circunscripcion)
    {
        $circunscripciones = Circunscripciones::where('name', 'like', "%{$circunscripcion}%")->select('id')->get();
        $circunscripciones = $circunscripciones->toArray();
        
        $circunscripcionesId = array_map(function($circunscripcion){
            return $circunscripcion['id'];;
        }, $circunscripciones);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'circunscripciones_id',
            'value' => implode(',', $circunscripcionesId)
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }
}
