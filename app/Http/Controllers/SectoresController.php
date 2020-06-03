<?php

namespace App\Http\Controllers;

use App\Sectores;
use Fredpeal\BakaHttp\Traits\CrudTrait;

class SectoresController extends Controller
{
    //
    use CrudTrait;

    //
    public function __construct()
    {
        $this->model = new Sectores;
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
                'municipios' => $model->municipios ? [
                    'id' => $model->municipios->id,
                    'name' => $model->municipios->name,
                ] : [],
                'distritos' => $model->distritos ? [
                    'id' => $model->distritos->id,
                    'name' => $model->distritos->name,
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
