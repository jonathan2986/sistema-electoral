<?php

namespace App\Http\Controllers;

use App\Colegio;
use Illuminate\Http\Request;

class ColegioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            $buscar = $request->buscar;
            $criterio = $request->criterio;

            if ($buscar == ''){
                $colegios = Colegio::orderBy('id','desc')->paginate(4);
            }else{
                $colegios = Colegio::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id', 'desc')->paginate(4);
            }


            return [
            'pagination' => [
                'total'        => $colegios->total(),
                'current_page' => $colegios->currentPage(),
                'per_page'     => $colegios->perPage(),
                'last_page'    => $colegios->lastPage(),
                'from'         => $colegios->firstItem(),
                'to'           => $colegios->lastItem(),
            ],
            'colegios' => $colegios
        ];
    }



        public function selectColegio(Request $request){
        if (!$request->ajax()) return redirect('/');
            $colegios = Colegio::select('id','distrito_municipal')
                ->orderBy('distrito_municipal', 'asc')->get();
            return ['colegios' => $colegios];
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
        $colegio = new Colegio();
        $colegio->provincia = $request->provincia;
        $colegio->municipio = $request->municipio;
        $colegio->distrito_municipal = $request->distrito_municipal;
        $colegio->circuscripcion = $request->circuscripcion;
        $colegio->save();
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
        $colegio = Colegio::findOrFail($request->id);
        $colegio->provincia = $request->provincia;
        $colegio->municipio = $request->municipio;
        $colegio->distrito_municipal = $request->distrito_municipal;
        $colegio->circuscripcion = $request->circuscripcion;
        $colegio->save();

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
