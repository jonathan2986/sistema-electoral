<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $personas = Persona::join('colegios_electorales','personas.idcolegio_electoral', '=','colegios_electorales.id')
                ->select('personas.id','personas.idcolegio_electoral','colegios_electorales.numero_colegio','personas.nombre','personas.apellido','personas.cedula',
                        'personas.direccion','personas.telefono','personas.voto')
                ->orderBy('personas.id', 'desc')->paginate(4);
        }else{
            $personas =  Persona::join('colegios_electorales','personas.idcolegio_electoral', '=','colegios_electorales.id')
                ->select('personas.id','personas.idcolegio_electoral','colegios_electorales.numero_colegio','personas.nombre','personas.apellido','personas.cedula',
                    'personas.direccion','personas.telefono','personas.voto')
                ->where('recinto_electoral.'.$criterio, 'like', '%'. $buscar .'%')
                ->orderBy('personas.id', 'desc')->paginate(4);
        }


        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = new Persona();
        $persona->idcolegio_electoral = $request->idcolegio_electoral;
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->cedula = $request->cedula;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->voto = $request->voto;
        $persona->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->idcolegio_electoral = $request->idcolegio_electoral;
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->cedula = $request->cedula;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->voto = '0';
        $persona->save();
    }

    public function agregarVoto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->voto = '1';
        $persona->save();
    }

    public function quitarVoto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->voto = '0';
        $persona->save();
    }
}
