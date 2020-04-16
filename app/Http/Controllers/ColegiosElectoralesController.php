<?php

namespace App\Http\Controllers;

use App\ColegiosElectorales;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use App\Recintos;
class ColegiosElectoralesController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new ColegiosElectorales;
    }

    
    public function searchByRecintos($recintoName)
    {
        $request = $request->toArray();
        $recintos = Recintos::where('name','like',"%{$recintoName}%")->select('id')->get();
        $recintosId = $recintos->toArray();
        $request['q'][] = json_encode([
            'condition' =>'whereIn',
            'field' => 'recintos_id',
            'value' => implode(',', $recintosId)
        ]);
        $data = $this->search($request);
        return response()->json($data);
    }
}
