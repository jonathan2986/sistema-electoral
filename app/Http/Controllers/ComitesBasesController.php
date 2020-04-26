<?php

namespace App\Http\Controllers;

use App\ComitesBases;
use DB;
use Exception;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;

class ComitesBasesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new ComitesBases;
    }

    /**
     *  store function
     *  @var $request Request
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataStore = $request->toArray();
            $comiteBase = $this->model::where('people_id', $request['people_id'])->first();
            $comiteBaseNumber = $this->model::max('name');
            $comiteBaseNumber = $comiteBaseNumber ? intval($comiteBaseNumber) + 1 : 1;
            $dataStore['name'] = $comiteBaseNumber;
            if ($comiteBase) {
                DB::rollback();
                return response()->json(['message' => 'Este lider ya existe'], 500);
            }
            $dataStore['name'] = str_pad($dataStore['name'], 5, "0", STR_PAD_LEFT);
            $data = $this->model::create($dataStore);
            DB::commit();
            $data = $this->model::find($data->id);
            $data->load('people');
            return response()->json($data);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }

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
        if (key_exists('name', $data)) {
            $data['name'] = str_pad($data['name'], 5, "0", STR_PAD_LEFT);
        }
        $this->model::where('id', '=', $id)
            ->update($data);
        $data = $this->model::find($id);
        return response()->json($data);
    }
}
