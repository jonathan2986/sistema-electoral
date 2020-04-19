<?php

namespace App\Http\Controllers;

use App\Votantes;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use App\Circunscripciones; 
use App\Municipios;
use App\Distritos;
use App\Recintos;
use App\ColegiosElectorales;
use Illuminate\Http\Request;

class VotantesController extends Controller
{
    //
    use CrudTrait;

    //
    public function __construct()
    {
        $this->model = new Votantes;
    }
    
    /**
     * getByCircunscripciones function
     *
     * @param  mixed $request
     * @param  mixed $name
     * @return void
     */
    public function getByCircunscripciones(Request $request, $name)
    {
        $circunscripciones = Circunscripciones::where('name', 'like', "%{$name}%")->select('id')->get();
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

    
    /**
     * getByMunicipios function
     *
     * @param  mixed $request
     * @param  mixed $name
     * @return void
     */
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
    
    /**
     * getByDistritos
     *
     * @param  mixed $request
     * @param  mixed $name
     * @return void
     */
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

    public function getByRecintos(Request $request, $name)
    {
        $recintos = Recintos::where('name', 'like', "%{$name}%")->select('id')->get();
        $recintos = $recintos->toArray();
        
        $recintosId = array_map(function($recinto){
            return $recinto['id'];;
        }, $recintos);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'recintos_id',
            'value' => implode(',', $recintosId)
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }

    public function getByColegiosElectorales(Request $request, $name)
    {
        $recintos = Recintos::where('name', 'like', "%{$name}%")->select('id')->get();
        $recintos = $recintos->toArray();
        
        $recintosId = array_map(function($recinto){
            return $recinto['id'];;
        }, $recintos);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'recintos_id',
            'value' => implode(',', $recintosId)
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }
}
