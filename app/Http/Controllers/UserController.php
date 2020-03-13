<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
//        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
                ->join('colegios_electorales','personas.idcolegio_electoral', '=','colegios_electorales.id')
                ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.idcolegio_electoral','colegios_electorales.numero_colegio','personas.nombre','personas.apellido',
                'personas.cedula','personas.direccion','personas.telefono',
                'personas.voto','users.usuario','users.password',
                'users.condicion','users.idrol','roles.nombre as rol')
            ->orderBy('personas.id', 'desc')->paginate(3);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
                ->join('roles','users.idrol','=','roles.id')
                ->select('personas.id','personas.nombre','personas.apellido',
                    'personas.cedula','personas.direccion','personas.telefono',
                    'personas.voto','users.usuario','users.password',
                    'users.condicion','users.idrol','roles.nombre as rol')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(3);
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

    public function selectUsuario(Request $request){
//        if (!$request->ajax()) return redirect('/');

        $usuarios = User::select('id','usuario')
            ->where('condicion', '=', '1')
            ->orderBy('usuario', 'asc')->get();
        return ['usuarios' => $usuarios];
    }
    public function selectUsuarioFiltro(Request $request){
     //   if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;

        $usuarios = User::join('personas','users.id','=','personas.id')
                        ->join('roles','users.idrol','=','roles.id')
            ->where('personas.nombre','like', '%'. $filtro . '%')
            ->orWhere('personas.cedula','like','%' .$filtro . '%')
            ->select('personas.id','personas.nombre','personas.apellido','personas.cedula','users.usuario','users.idrol','roles.nombre as rol')
            ->orderBy('personas.nombre','asc')->get();

        return ['usuarios' => $usuarios];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->idcolegio_electoral = $request->idcolegio_electoral;
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->cedula = $request->cedula;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->voto = $request->voto;
            $persona->save();

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;

            $user->id = $persona->id;

            $user->save();

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

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);

            $persona = Persona::findOrFail($user->id);

            $persona->idcolegio_electoral = $request->idcolegio_electoral;
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->cedula = $request->cedula;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->voto = '0';
            $persona->save();


            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();


            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
