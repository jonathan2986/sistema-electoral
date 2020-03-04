<?php

namespace App\Http\Controllers;

use DemeterChain\C;
use Illuminate\Http\Request;
use App\ColegioElectoral;

class ColegioElectoralController extends Controller
{
    public function index(Request $request){

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $colegio_electoral = ColegioElectoral::join('recinto_electoral','colegios_electorales.idrecinto', '=','recinto_electoral.id')
                ->select('colegios_electorales.id','colegios_electorales.idrecinto','recinto_electoral.nombre_recinto','colegios_electorales.numero_colegio','colegios_electorales.cantidad_electores')
                ->orderBy('recinto_electoral.id', 'desc')->paginate(4);
        }else{
            $colegio_electoral = ColegioElectoral::join('recinto_electoral','colegios_electorales.idrecinto', '=','recinto_electoral.id')
                ->select('colegios_electorales.id','colegios_electorales.idrecinto','recinto_electoral.nombre_recinto','colegios_electorales.numero_colegio','colegios_electorales.cantidad_electores')
                ->where('colegios_electorales.'.$criterio, 'like', '%'. $buscar .'%')
                ->orderBy('colegios_electorales.id', 'desc')->paginate(4);
        }


        return [
            'pagination' => [
                'total'        => $colegio_electoral->total(),
                'current_page' => $colegio_electoral->currentPage(),
                'per_page'     => $colegio_electoral->perPage(),
                'last_page'    => $colegio_electoral->lastPage(),
                'from'         => $colegio_electoral->firstItem(),
                'to'           => $colegio_electoral->lastItem(),
            ],
            'colegio_electoral' => $colegio_electoral
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $colegio_electoral = new ColegioElectoral();
        $colegio_electoral->idrecinto = $request->idrecinto;
        $colegio_electoral->numero_colegio = $request->numero_colegio;
        $colegio_electoral->cantidad_electores = $request->cantidad_electores;
        $colegio_electoral->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $colegio_electoral = ColegioElectoral::findOrFail($request->id);
        $colegio_electoral->idrecinto = $request->idrecinto;
        $colegio_electoral->numero_colegio = $request->numero_colegio;
        $colegio_electoral->cantidad_electores = $request->cantidad_electores;
        $colegio_electoral->save();
    }

}
