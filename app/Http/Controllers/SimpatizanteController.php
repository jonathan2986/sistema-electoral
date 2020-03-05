<?php

namespace App\Http\Controllers;

use App\Simpatizante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persona;

class SimpatizanteController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $simpatizantes = Simpatizante::join('personas','simpatizante.id','=','personas.id')
                                    ->join('colegios_electorales','simpatizante.idcolegio_electoral', '=','colegios_electorales.id')
                                    ->select('personas.id','personas.nombre','personas.apellido','personas.cedula','personas.telefono','colegios_electorales.id','simpatizante.idcolegio_electoral','colegios_electorales.numero_colegio',
                                            'simpatizante.mesa_electoral','simpatizante.voto_simpatizantes')->orderBy('personas.id','desc')->paginate(4);
        }else{
            $simpatizantes = Simpatizante::join('personas','simpatizante.id','=','personas.id')
                ->join('colegios_electorales','simpatizante.idcolegio_electoral', '=','colegios_electorales.id')
                ->select('personas.id','personas.nombre','persona.apellido','personas.cedula','personas.telefono','colegios_electorales.id','simpatizante.idcolegio_electoral','colegios_electorales.numero_colegio',
                    'simpatizante.mesa_electoral','simpatizante.voto_simpatizantes')
                ->where('personas'.$criterio, 'like', '%'. $buscar .'%')->orderBy('personas.id','desc')->paginate(4);
        }


        return [
            'pagination' => [
                'total'        => $simpatizantes->total(),
                'current_page' => $simpatizantes->currentPage(),
                'per_page'     => $simpatizantes->perPage(),
                'last_page'    => $simpatizantes->lastPage(),
                'from'         => $simpatizantes->firstItem(),
                'to'           => $simpatizantes->lastItem(),
            ],
            'simpatizantes' => $simpatizantes
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->cedula = $request->cedula;
            $persona->telefono = $request->telefono;
            $persona->save();

            $simpatizante = new Simpatizante();
            $simpatizante->idcolegio_electoral = $request->idcolegio_electoral;
            $simpatizante->mesa_electoral = $request->mesa_electoral;
            $simpatizante->voto_simpatizante = '0';
            $simpatizante->id = $persona->id;
            $simpatizante->save();

            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
       }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();
            //buscar el simpatizante a modificar
            $simpatizante = Simpatizante::findOrFail($request->id);

            $persona = Persona::findOrFail($simpatizante->id);
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->cedula = $request->cedula;
            $persona->telefono = $request->telefono;
            $persona->save();

            $simpatizante = new Simpatizante();
            $simpatizante->idcolegio_electoral = $request->idcolegio_electoral;
            $simpatizante->mesa_electoral = $request->mesa_electoral;
            $simpatizante->voto_simpatizante = '0';
            $simpatizante->id = $persona->id;

            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
        }

        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->cedula = $request->cedula;
        $persona->direccion = $request->direccion;
        $persona->email = $request->email;
        $persona->telefono = $request->telefono;
        $persona->save();
    }

    public function agregarVoto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $simpatizante = Simpatizante::findOrFail($request->id);
        $simpatizante->voto_simpatizante = '1';
        $simpatizante->save();
    }

    public function quitarVoto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $simpatizante = Simpatizante::findOrFail($request->id);
        $simpatizante->voto_simpatizante = '0';
        $simpatizante->save();
    }
}
