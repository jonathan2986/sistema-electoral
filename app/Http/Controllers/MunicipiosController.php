<?php

namespace App\Http\Controllers;

use App\Municipios;
use App\Provincias;
use Fredpeal\BakaHttp\Traits\CrudTrait;
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

        $provinciasId = array_map(function ($provincia) {
            return $provincia['id'];;
        }, $provincias);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'provincias_id',
            'value' => implode(',', $provinciasId),
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
                'provincias_id' => $model->provincias_id,
                'name' => $model->name,
                'coordinadores_id' => $model->coordinadores_id,
                'recintos_number' => $model->recintos_number,
                'distritos_number' => $model->distritos_number,
                'provincias' => $model->provincias ? [
                    'id' => $model->provincias->id,
                    'name' => $model->provincias->name,
                ] : [],
                'circunscripciones' => $model->circunscripciones ? [
                    'id' => $model->circunscripciones->id,
                    'name' => $model->circunscripciones->name,
                ] : [],
                'coordinadores' => $model->coordinadores ? [
                    'id' => $model->coordinadores->id,
                    'first_name' => $model->coordinadores->first_name,
                    'last_name' => $model->coordinadores->last_name,
                ] : false,
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
