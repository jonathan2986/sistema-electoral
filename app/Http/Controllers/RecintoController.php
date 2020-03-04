<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recinto;

class RecintoController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $recinto = Recinto::join('colegios','recinto_electoral.idcolegio', '=','colegios.id')
                ->select('recinto_electoral.id','recinto_electoral.idcolegio','colegios.distrito_municipal','recinto_electoral.nombre_recinto','recinto_electoral.direccion')
                ->orderBy('recinto_electoral.id', 'desc')->paginate(4);
        }else{
            $recinto = Recinto::join('colegios','recinto_electoral.idcolegio', '=','colegios.id')
                ->select('recinto_electoral.id','recinto_electoral.idcolegio','colegios.distrito_municipal','recinto_electoral.nombre_recinto','recinto_electoral.direccion')
                ->where('recinto_electoral.'.$criterio, 'like', '%'. $buscar .'%')
                ->orderBy('recinto_electoral.id', 'desc')->paginate(4);
        }


        return [
            'pagination' => [
                'total'        => $recinto->total(),
                'current_page' => $recinto->currentPage(),
                'per_page'     => $recinto->perPage(),
                'last_page'    => $recinto->lastPage(),
                'from'         => $recinto->firstItem(),
                'to'           => $recinto->lastItem(),
            ],
            'recintos' => $recinto
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $recinto = new Recinto();
        $recinto->idcolegio = $request->idcolegio;
        $recinto->nombre_recinto = $request->nombre_recinto;
        $recinto->direccion = $request->direccion;
        $recinto->save();
    }

    public function selectRecinto(Request $request){
        if (!$request->ajax()) return redirect('/');
        $recintos = Recinto::select('id','nombre_recinto')
            ->orderBy('nombre_recinto', 'asc')->get();
        return ['recintos' => $recintos];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $recinto = Recinto::findOrFail($request->id);
        $recinto->idcolegio = $request->idcolegio;
        $recinto->nombre_recinto = $request->nombre_recinto;
        $recinto->direccion = $request->direccion;
        $recinto->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
