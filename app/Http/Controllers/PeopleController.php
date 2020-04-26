<?php

namespace App\Http\Controllers;

use App\ColegiosElectorales;
use App\ComitesBases;
use App\People;
use App\Recintos;
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

    public function bulkEdit(Request $request)
    {
        $request = $request->toArray();
        foreach ($request['miembros'] as $miembros) {
            unset($miembros['label']);
            $miembros['comites_bases_id'] = $request['comites_bases_id'];
            People::create($miembros);
        }
    }

    public function searchByComitesBases(Request $request, $comiteBase)
    {
        $comitesBases = ComitesBases::where('name', 'like', "%{$comiteBase}%")->select('id')->get();
        $comitesBases = $comitesBases->toArray();

        $comitesBasesId = array_map(function ($comite) {
            return $comite['id'];;
        }, $comitesBases);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'comites_bases_id',
            'value' => implode(',', $comitesBasesId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }

    public function searchByRecintos(Request $request, $recinto)
    {
        $recintos = Recintos::where('name', 'like', "%{$recinto}%")->select('id')->get();
        $recintos = $recintos->toArray();

        $recintosId = array_map(function ($model) {
            return $model['id'];;
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

    public function searchByColegiosElectorales(Request $request, $recinto)
    {
        $colegiosElectorales = ColegiosElectorales::where('name', 'like', "%{$recinto}%")->select('id')->get();
        $colegiosElectorales = $colegiosElectorales->toArray();

        $colegiosElectoralesId = array_map(function ($model) {
            return $model['id'];;
        }, $colegiosElectorales);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'colegios_electorales_id',
            'value' => implode(',', $colegiosElectoralesId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }
}
