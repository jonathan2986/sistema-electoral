<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partido;

class PartidoController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $partidos = Partido::orderBy('id','desc')->paginate(4);
        }else{
            $partidos = Partido::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id', 'desc')->paginate(3);
        }


        return [
            'pagination' => [
                'total'        => $partidos->total(),
                'current_page' => $partidos->currentPage(),
                'per_page'     => $partidos->perPage(),
                'last_page'    => $partidos->lastPage(),
                'from'         => $partidos->firstItem(),
                'to'           => $partidos->lastItem(),
            ],
            'partidos' => $partidos
        ];
    }

    public function selectPartido(Request $request)
    {
        $partido = Partido::select('id','siglas')
            ->orderBy('siglas', 'asc')->get();

        return ['partido' => $partido];
    }

    public function getTotalPartidos(){
        $partidos = Partido::get()->count();

        return ['partidos' => $partidos ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $partido = new Partido();
        $partido->nombre_partido = $request->nombre_partido;
        $partido->siglas = $request->siglas;
        $partido->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $partido = Partido::findOrFail($request->id);
        $partido->nombre_partido = $request->nombre_partido;
        $partido->siglas = $request->siglas;
        $partido->save();
    }
}
