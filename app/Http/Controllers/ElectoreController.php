<?php

namespace App\Http\Controllers;

use App\DetalleElector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Elector;
use App\Persona;

class ElectoreController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $electores = Elector::join('users','electores.idusuario','=','users.id')
                ->join('colegios_electorales','electores.idcolegio_electoral','=','colegios_electorales.id')
                ->join('personas','electores.idpersona','=','personas.id')
            ->select('personas.id','personas.nombre','personas.apellido',
                'personas.cedula','personas.direccion','personas.telefono',
                'colegios_electorales.numero_colegio','electores.votosComputados', 'users.usuario')
            ->orderBy('personas.id', 'desc')->paginate(4);
        }
        else{
            $electores = Elector::join('users','electores.idusuario','=','users.id')
                    ->join('colegios_electorales','electores.idcolegio_electoral','=','colegios_electorales.id')
                    ->select('electores.id','electores.nombre','electores.apellido',
                        'electores.cedula','electores.direccion','electores.telefono','electores.voto',
                        'colegios_electorales.numero_colegio','users.usuario')
            ->where('electores.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('electores.id', 'desc')->paginate(4);
        }

        return [
            'pagination' => [
        'total'        => $electores->total(),
                'current_page' => $electores->currentPage(),
                'per_page'     => $electores->perPage(),
                'last_page'    => $electores->lastPage(),
                'from'         => $electores->firstItem(),
                'to'           => $electores->lastItem(),
            ],
            'electores' => $electores
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

//            $mytime= Carbon::now('America/Santo_Domingo');

            $persona = new Persona();
            $persona->idcolegio_electoral = $request->idcolegio_electoral;
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->cedula = $request->cedula;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->save();

            $elector = new Elector();
            $elector->idcolegio_electoral = $request->idcolegio_electoral;
            $elector->idusuario = \Auth::user()->id;
            $elector->idpersona= $request->idpersona;
            $elector->votosComputados = 0;
            $elector->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

//            $mytime= Carbon::now('America/Santo_Domingo');

            $elector = Elector::findOrFail($request->id);
            $elector->idcolegio_electoral = $request->idcolegio_electoral;
            $elector->idusuario = \Auth::user()->id;
            $elector->nombre = $request->nombre;
            $elector->apellido = $request->apellido;
            $elector->cedula = $request->cedula;
            $elector->direccion = $request->direccion;
            $elector->telefono = $request->telefono;
            $elector->voto = 0;
            $elector->save();

//            $detalles = $request->data;//Array de detalles
//            //Recorro todos los elementos
//
//            foreach($detalles as $ep=>$det)
//            {
//                $detalle = new DetalleElector();
//                $detalle->idelectores = $elector->id;
//                $detalle->idusuario = $det['idusuario'];
//                $detalle->cantidad_electores = $det['cantidad_electores'];
//                $detalle->save();
//            }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function agregarVoto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $elector = Elector::findOrFail($request->id);
        $elector->voto = '1';
        $elector->save();
    }

    public function quitarVoto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $elector = Elector::findOrFail($request->id);
        $elector->voto = '0';
        $elector->save();
    }
}
