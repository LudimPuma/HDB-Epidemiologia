<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    // public function __constructo()
    // {
    //     $this->middleware(['can:admin', 'second'])->group(function () {

    //     });
    // }
    // public function __construct(){
    //     $this->middleware('can:admin')->only('index');
    //     $this->middleware('can:admin')->only('index');
    //     $this->middleware('can:admin')->only('index');
    //     $this->middleware('can:admin')->only('index');
    //     $this->middleware('can:admin')->only('index');
    // }
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ci'  => 'required',
            'extension' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'genero' => 'required',
            'direccion' => 'required',
            'celular' => 'required',
            'fecha_nacimiento' => 'required',
            'estado_civil' => 'required',

            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'profesion' => 'required',
            'cargo' => 'required',
            'area' => 'required',
        ]);

        $persona = new Persona();
        $persona->ci = $request->input('ci');
        $persona->extension = $request->input('extension');
        $persona->nombres = $request->input('nombres');
        $persona->apellidos = $request->input('apellidos');
        $persona->genero = $request->input('genero');
        $persona->direccion = $request->input('direccion');
        $persona->telefono = $request->input('telefono');
        $persona->celular = $request->input('celular');
        $persona->fecha_nacimiento = $request->input('fecha_nacimiento');
        $persona->estado_civil = $request->input('estado_civil');
        // $persona->resgister = Auth::id();
        $persona->save();

        $user = new User();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->profesion = $request->input('profesion');
        $user->matricula_profesion = $request->input('matricula_profesion');
        $user->cargo = $request->input('cargo');
        $user->area = $request->input('area');
        $user->persona_id = $persona->id;
        // $user->resgister = Auth::id();
        $user->save();
        $user->assignRole($request->input('roles'));
        return redirect()->route('usuarios.index')->with('success', 'Usuario y persona creados exitosamente');
    }

    public function show($id)
    {
        $user = User::find($id);
        $roles = $user->roles;
        $rolePermissions = [];

        foreach ($roles as $role) {
            $permissions = $role->permissions;
            $rolePermissions[$role->name] = $permissions;
        }
        return view('admin.users.show', compact('user', 'roles', 'rolePermissions'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $model_type='App\User';
        return view('admin.users.edit', compact('user', 'roles','model_type'));
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $persona = $user->persona;

        // Validación de campos
        $this->validate($request, [
            'ci' => 'required',
            'extension' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'genero' => 'required',
            'direccion' => 'required',
            'celular' => 'required',
            'fecha_nacimiento' => 'required',
            'estado_civil' => 'required',
            'email' => 'required',
            'profesion' => 'required',
            'cargo' => 'required',
            'area' => 'required',
        ]);

        // Actualizar los detalles de la Persona
        $persona->update([
            'ci' => $request->input('ci'),
            'extension' => $request->input('extension'),
            'nombres' => $request->input('nombres'),
            'apellidos' => $request->input('apellidos'),
            'genero' => $request->input('genero'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
            'celular' => $request->input('celular'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'estado_civil' => $request->input('estado_civil'),
        ]);

        // Actualizar los detalles del Usuario, incluyendo la contraseña si se proporciona
        $user->email = $request->input('email');
        $user->estado = $request->input('estado', 'enable');
        $user->profesion = $request->input('profesion');
        $user->matricula_profesion = $request->input('matricula_profesion');
        $user->matricula_colegio = $request->input('matricula_colegio');
        $user->cargo = $request->input('cargo');
        $user->area = $request->input('area');

        // Actualizar la contraseña solo si se proporciona una nueva
        if ($request->has('password') && !empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();
        $user->syncRoles($request->input('roles'));

        return redirect()->route('usuarios.index')->with('success', 'Usuario y persona actualizados exitosamente');
    }

    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, [

    //         'roles' => 'required|array',
    //     ]);

    //     $user = User::find($id);
    //     $user->email = $request->input('email');
    //     $user->save();
    //     $user->syncRoles($request->input('roles'));
    //     return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    // }

}
