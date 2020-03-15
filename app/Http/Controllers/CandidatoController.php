<?php

namespace App\Http\Controllers;

use App\Candidato;
use App\Partido;
use Illuminate\Http\Request;

class CandidatoController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $candidatos = Candidato::join('partidos','candidatos.idpartido', '=','partidos.id')
                ->select('candidatos.id','candidatos.idpartido','candidatos.nombre_candidato','candidatos.tipo_candidatura','partidos.siglas')
                ->orderBy('candidatos.id', 'desc')->paginate(4);
        }else{
            $candidatos = Candidato::join('partidos','candidatos.idpartido', '=','partidos.id')
                ->select('candidatos.id','candidatos.idpartido','candidatos.nombre_candidato','candidatos.tipo_candidatura','partidos.siglas')
                ->where('candidatos.'.$criterio, 'like', '%'. $buscar .'%')
                ->orderBy('candidatos.id', 'desc')->paginate(4);
        }


        return [
            'pagination' => [
                'total'        => $candidatos->total(),
                'current_page' => $candidatos->currentPage(),
                'per_page'     => $candidatos->perPage(),
                'last_page'    => $candidatos->lastPage(),
                'from'         => $candidatos->firstItem(),
                'to'           => $candidatos->lastItem(),
            ],
            'candidatos' => $candidatos
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
//        if (!$request->ajax()) return redirect('/');
        $candidato = new Candidato();
        $candidato->idpartido = $request->idpartido;
        $candidato->nombre_candidato = $request->nombre_candidato;
        $candidato->tipo_candidatura= $request->tipo_candidatura;
        $candidato->save();
    }

    public function selectCandidato(Request $request){
//        if (!$request->ajax()) return redirect('/');

        $candidatos = Candidato::select('id','nombre_candidato', 'tipo_candidatura')
            ->orderBy('nombre_candidato', 'asc')->get();
        return ['candidatos' => $candidatos];
    }

//    public function selectRecinto(Request $request){
//        if (!$request->ajax()) return redirect('/');
//        $recintos = Recinto::select('id','nombre_recinto')
//            ->orderBy('nombre_recinto', 'asc')->get();
//        return ['recintos' => $recintos];
//    }

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
        $candidato = Candidato::findOrFail($request->id);
        $candidato->idpartido = $request->idpartido;
        $candidato->nombre_candidato = $request->nombre_candidato;
        $candidato->tipo_candidatura= $request->tipo_candidatura;
        $candidato->save();
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
