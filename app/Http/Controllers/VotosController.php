<?php

namespace App\Http\Controllers;
use App\Candidato;
use App\Voto;

use Illuminate\Http\Request;

class VotosController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $votos = Voto::join('candidatos','votos.idcandidato', '=','candidatos.id')
                ->join('partidos','votos.idpartido', '=','partidos.id')
                ->select('votos.id','votos.idcandidato','votos.voto_candidato','votos.voto_nulo','votos.votos_valido','votos.boletas_observada','votos.total_voto',
                    'candidatos.nombre_candidato','candidatos.tipo_candidatura','partidos.siglas')
                ->orderBy('votos.id', 'desc')->paginate(13);
        }else{
            $votos = Voto::join('candidatos','votos.idcandidato', '=','candidatos.id')
                ->join('partidos','votos.idpartido', '=','partidos.id')
                ->select('votos.id','votos.idcandidato','votos.voto_candidato','votos.voto_nulo','votos.votos_valido','votos.boletas_observada','votos.total_voto',
                    'candidatos.nombre_candidato','candidatos.tipo_candidatura','partidos.siglas')
                ->where('votos.'.$criterio, 'like', '%'. $buscar .'%')
                ->orderBy('votos.id', 'desc')->paginate(13);
        }


        return [
            'pagination' => [
                'total'        => $votos->total(),
                'current_page' => $votos->currentPage(),
                'per_page'     => $votos->perPage(),
                'last_page'    => $votos->lastPage(),
                'from'         => $votos->firstItem(),
                'to'           => $votos->lastItem(),
            ],
            'votos' => $votos
        ];
    }
    public function calcularVotosCandidato(){
        $total = Voto::sum('votos.voto_candidato');

        return ['votos' => $total];
    }
    public function calcularVotosCandidatoId(){
        $total = Voto::sum('votos.voto_candidato')
        ->where('votos.id', '=', 'id');

        return ['votos' => $total];
    }
    public function calcularVotosNulo(){
        $total = Voto::sum('votos.voto_nulo');

        return ['votos' => $total];
    }


    public function selectTotalVotos(Request $request)
    {
        $votos = Voto::where('votos.id', '=', '1')
            ->select('id','votos.voto_nulo','votos.votos_valido','votos.total_voto')->get();

        return ['votos' => $votos];
    }

    public function mostrarDetalle(Request $request){
        $voto = Voto::latest()
            ->take(1)
            ->get();

        return ['votos' => $voto];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $voto = new Voto();
        $voto->idcandidato = $request->idcandidato;
        $voto->idpartido = $request->idpartido;
        $voto->voto_candidato = $request->voto_candidato;
        $voto->voto_nulo = $request->voto_nulo;
        $voto->votos_valido = $request->votos_valido;
        $voto->boletas_observada = $request->boletas_observada;
        $voto->total_voto = $request->total_voto;
        $voto->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $voto = Voto::findOrFail($request->id);
        $voto->idcandidato = $request->idcandidato;
        $voto->idpartido = $request->idpartido;
        $voto->voto_candidato = $request->voto_candidato;
        $voto->voto_nulo = $request->voto_nulo;
        $voto->votos_valido = $request->votos_valido;
        $voto->boletas_observada = $request->boletas_observada;
        $voto->total_voto = $request->total_voto;
        $voto->save();
    }
}
