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
        if (!$comitesBases) {
            return response()->json([]);
        }
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
        if (!$recintos) {
            return response()->json([]);
        }
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
        if (!$colegiosElectorales) {
            return response()->json([]);
        }
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

    /**
     * search function
     *
     * @param  mixed $request
     * @return
     */
    public function search(array $request)
    {
        $model = $this->model::query();

        #Pagination Vars

        $perPage = key_exists('perPage', $request) ? $request['perPage'] : 5;
        $page = key_exists('page', $request) ? $request['page'] : 1;
        $offset = $page == 1 ? 0 : intval($perPage) * intval($page - 1);
        if (key_exists('q', $request)) {
            foreach ($request['q'] as $key) {
                $q = json_decode($key, true);
                $this->model = $this->conditions($model, $q);
            }
        }
        $totalResult = $this->model->count();
        $lastPage = ceil($totalResult / intval($perPage));

        $data = $this->model->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $dataResponse = [];

        foreach ($data as $model) {
            $dataResponse[] = [
                'id' => $model->id,
                'circunscripciones_id' => $model->circunscripciones_id,
                'municipios_id' => $model->municipios_id,
                'distritos_id' => $model->distritos_id,
                'recintos_id' => $model->recintos_id,
                'colegios_electorales_id' => $model->colegios_electorales_id,
                'comites_bases_id' => $model->comites_bases_id,
                'confirmado' => $model->confirmado,
                'first_name' => $model->first_name,
                'last_name' => $model->last_name,
                'card_id' => $model->card_id,
                'phone_number' => $model->phone_number,
                'celphone' => $model->celphone,
                'email' => $model->email,
                'date_birthdate' => $model->date_birthdate,
                'profession' => $model->profession,
                'address' => $model->address,
                'sector' => $model->sector,
                'sexo' => $model->sexo,
                'age' => $model->age,
                'name' => $model->name,
                'municipios' => $model->municipios ? [
                    'id' => $model->municipios->id,
                    'name' => $model->municipios->name,
                ] : [],
                'distritos' => $model->distritos ? [
                    'id' => $model->distritos->id,
                    'name' => $model->distritos->name,
                ] : [],
                'recintos' => $model->recintos ? [
                    'id' => $model->recintos->id,
                    'name' => $model->recintos->name,
                ] : [],
                'colegios_electorales' => $model->colegios_electorales ? [
                    'id' => $model->colegios_electorales->id,
                    'name' => $model->colegios_electorales->name,
                ] : [],
                'comites_bases' => $model->comites_bases ? [
                    'id' => $model->comites_bases->id,
                    'name' => $model->comites_bases->name,
                ] : [],
            ];
        }

        /**
         * paginate data
         */
        $data = collect($dataResponse);
        $result = [
            'total' => $totalResult,
            'last_page' => $lastPage,
            'current_page' => $page,
            'data' => $data,
        ];
        return $result;
    }

}
