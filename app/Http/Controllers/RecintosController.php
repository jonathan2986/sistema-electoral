<?php

namespace App\Http\Controllers;

use App\Distritos;
use App\Municipios;
use App\Recintos;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;

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

        $distritosId = array_map(function ($distrito) {
            return $distrito['id'];;
        }, $distritos);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'distritos_id',
            'value' => implode(',', $distritosId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }

    public function getByMunicipios(Request $request, $name)
    {
        $municipios = Municipios::where('name', 'like', "%{$name}%")->select('id')->get();
        $municipios = $municipios->toArray();

        $municipiosId = array_map(function ($municipio) {
            return $municipio['id'];;
        }, $municipios);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'municipios_id',
            'value' => implode(',', $municipiosId),
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
                'municipios_id' => $model->municipios_id,
                'distritos_id' => $model->distritos_id,
                'name' => $model->name,
                'address' => $model->address,
                'coordinadores_id' => $model->coordinadores_id,
                'coordinadores_ejecutivos_id' => $model->coordinadores_ejecutivos_id,
                'coordinadores_electorales_id' => $model->coordinadores_electorales_id,
                'coordinadores_seguridad_id' => $model->coordinadores_seguridad_id,
                'coordinadores_finanzas_id' => $model->coordinadores_finanzas_id,
                'activistas_id' => $model->activistas_id,
                'number_colegios' => $model->number_colegios,
                'coordinadores' => $model->coordinadores ? [
                    'id' => $model->coordinadores->id,
                    'first_name' => $model->coordinadores->first_name,
                    'last_name' => $model->coordinadores->last_name,
                ] : false,
                'distritos' => $model->distritos ? [
                    'id' => $model->distritos->id,
                    'name' => $model->distritos->name,
                ] : false,
                'coordinadores_ejecutivos' => $model->coordinadores_ejecutivos ? [
                    'id' => $model->coordinadores_ejecutivos->id,
                    'first_name' => $model->coordinadores_ejecutivos->first_name,
                    'last_name' => $model->coordinadores_ejecutivos->last_name,
                ] : false,
                'coordinadores_electorales' => $model->coordinadores_electorales ? [
                    'id' => $model->coordinadores_electorales->id,
                    'first_name' => $model->coordinadores_electorales->first_name,
                    'last_name' => $model->coordinadores_electorales->last_name,
                ] : false,
                'coordinadores_seguridad' => $model->coordinadores_seguridad ? [
                    'id' => $model->coordinadores_seguridad->id,
                    'first_name' => $model->coordinadores_seguridad->first_name,
                    'last_name' => $model->coordinadores_seguridad->last_name,
                ] : false,
                'coordinadores_finanzas' => $model->coordinadores_finanzas ? [
                    'id' => $model->coordinadores_finanzas->id,
                    'first_name' => $model->coordinadores_finanzas->first_name,
                    'last_name' => $model->coordinadores_finanzas->last_name,
                ] : false,
                'activistas' => $model->activistas ? [
                    'id' => $model->activistas->id,
                    'first_name' => $model->activistas->first_name,
                    'last_name' => $model->activistas->last_name,
                ] : false,
                'municipios' => $model->municipios ? [
                    'id' => $model->municipios->id,
                    'name' => $model->municipios->name,
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
