<?php

namespace App\Http\Controllers;

use App\ColegiosElectorales;
use App\People;
use App\Recintos;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;

class ColegiosElectoralesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new ColegiosElectorales;
    }

    /**
     *  store function
     *  @var $request Request
     */
    public function store(Request $request)
    {
        $dataStore = $request->toArray();
        $recinto = $this->model::where('name', $request['name'])
            ->where('recintos_id', $request['recintos_id'])
            ->first();
        if ($recinto) {
            return response()->json(['message' => 'Error, esta intentado agregar un recinto duplicado'], 404);
        }
        $data = $this->model::create($dataStore);
        return response()->json($data);
    }

    /**
     * update function
     * @var $request Request
     * $id integer
     */
    public function update(Request $request, $id)
    {
        $data = $request->toArray();
        if (array_key_exists('_url', $data)) {
            unset($data['_url']);
        }
        $recinto = $this->model::where('name', $request['name'])
            ->where('recintos_id', $request['recintos_id'])
            ->first();
        if ($recinto) {
            return response()->json(['message' => 'Error, esta intentado agregar un recinto duplicado'], 404);
        }
        $this->model::where('id', '=', $id)
            ->update($data);
        $data = $this->model::find($id);
        return response()->json($data);
    }

    /**
     * getByMunicipios
     *
     * @param  mixed $request
     * @param  mixed $name
     * @return void
     */
    public function getByMunicipios(Request $request, $name)
    {
        $recintos = Recintos::where('name', 'like', "%{$name}%")->select('id')->get();
        $recintos = $recintos->toArray();

        $recintosId = array_map(function ($recinto) {
            return $recinto['id'];;
        }, $recintos);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'recintos_id',
            'value' => implode(',', $recintosId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }

    /**
     * getByCoordinadores
     *
     * @param  mixed $request
     * @param  mixed $name
     * @return void
     */
    public function getByCoordinadores(Request $request, $name)
    {

        $params = explode(" ", $name);
        $coordinadores = People::where('first_name', 'like', "{$params[0]}")->select('id')->get();
        if (count($params) > 1) {
            $coordinadores = People::where('first_name', 'like', "{$params[0]}")
                ->where('last_name', 'ilke', "%{$params[1]}%")
                ->select('id')
                ->get();
        }
        $coordinadores = $coordinadores->toArray();

        $coordinadoresId = array_map(function ($coordinador) {
            return $coordinador['id'];;
        }, $coordinadores);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'coordinadores_id',
            'value' => implode(',', $coordinadoresId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }
}
