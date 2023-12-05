<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
        try{
            $this->validate($request, [
                'ci' => ['required', 'numbers_dash_letters', 'unique:personas,ci'],
                'extension' => 'required|letters_spaces',
                'nombres' => 'required|letters_spaces',
                'apellidos' => 'required|letters_spaces',
                'genero' => 'required|letters_spaces',
                'direccion' => 'required|letters_dash_spaces_dot',
                'celular' => 'required|only_numbers',
                'fecha_nacimiento' => 'required|numbers_with_dash',
                'estado_civil' => 'required|letters_dash_spaces_dot',

                'email' => ['required','unique:users','email_validator'],
                'password' => ['required', 'min:8', 'confirmed'],
                'profesion' => 'required|letters_dash_spaces_dot',
                'cargo' => 'required|letters_dash_spaces_dot',
                'area' => 'required|letters_spaces',
            ],
            [
                'ci.required' => 'El CI obigatorio',
                'ci.numbers_dash_letters'=> 'El CI puede incluir numeros letras y -',
                'ci.unique' => 'El CI ya está en uso',
                'extension.required' => 'La extensión es obligatoria',
                'extension.letters_spaces' => 'La extensión solo puede incluir letras',
                'nombres.required' => 'Los nombres son obligatorios',
                'nombres.letters_spaces' => 'Los nombres solo pueden incluir letras',
                'apellidos.required' => 'Los apellidos son obligatorios',
                'apellidos.letters_spaces' => 'Los apellidos solo pueden incluir letras',
                'genero.required' => 'El género es obligatorio',
                'genero.letters_spaces' => 'El género solo puede incluir letras',
                'direccion.required' => 'La dirección es obligatoria',
                'direccion.letters_dash_spaces_dot' => 'La dirección solo puede incluir letras, números, espacios, - y .',
                'celular.required' => 'El número de celular es obligatorio',
                'celular.only_numbers' => 'El número de celular solo puede incluir números',
                'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
                'fecha_nacimiento.numbers_with_dash' => 'La fecha de nacimiento solo puede incluir números y -',
                'estado_civil.required' => 'El estado civil es obligatorio',
                'estado_civil.letters_dash_spaces_dot' => 'El estado civil solo puede incluir letras',

                'email.required' => 'El correo electrónico es obligatorio',
                'email.unique' => 'El correo electrónico ya está en uso',
                'email.email_validator' => '150 caracteres como maximo. Unicamente letras, digitos y @/./-/_',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'profesion.required' => 'La profesión es obligatoria',
                'profesion.letters_dash_spaces_dot' => 'La profesión solo puede incluir letras',
                'cargo.required' => 'El cargo es obligatorio',
                'cargo.letters_dash_spaces_dot' => 'El cargo solo puede incluir letras',
                'area.required' => 'El área es obligatoria',
                'area.letters_spaces' => 'El área solo puede incluir letras',
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
            $persona->resgister = Auth::id();
            $persona->save();
            // imagen
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('images', 'public');
            }
            $user = new User();
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->profesion = $request->input('profesion');
            $user->matricula_profesion = $request->input('matricula_profesion');
            $user->cargo = $request->input('cargo');
            $user->area = $request->input('area');
            $user->persona_id = $persona->id;
            $user->resgister = Auth::id();
            $user->imagen=$imagenPath;
            $user->save();
            $user->assignRole($request->input('roles'));
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error al insertar usuario. Detalles: ' . $e->getMessage()]);
        }
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
        try{
            $user = User::find($id);
            $persona = $user->persona;
            if ($request->input('ci') !== $persona->ci) {
                $this->validate($request, [
                    'ci' => ['required', 'numbers_dash_letters', 'unique:personas,ci'],
                ], [
                    'ci.required' => 'El CI es obligatorio',
                    'ci.numbers_dash_letters' => 'El CI puede incluir números, letras y -',
                    'ci.unique' => 'El CI ya está en uso',
                ]);
            }

            $this->validate($request, [
                'extension' => 'required|letters_spaces',
                'nombres' => 'required|letters_spaces',
                'apellidos' => 'required|letters_spaces',
                'genero' => 'required|letters_spaces',
                'direccion' => 'required|letters_dash_spaces_dot',
                'celular' => 'required|only_numbers',
                'fecha_nacimiento' => 'required|numbers_with_dash',
                'estado_civil' => 'required|letters_dash_spaces_dot',

                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                    'email_validator'
                ],
                'password' => ['nullable', 'min:8', 'confirmed'],
                'profesion' => 'required|letters_dash_spaces_dot',
                'cargo' => 'required|letters_dash_spaces_dot',
                'area' => 'required|letters_spaces',
                'estado' => 'required|letters_spaces',
            ],

            [
                'extension.required' => 'La extensión es obligatoria',
                'extension.letters_spaces' => 'La extensión solo puede incluir letras',
                'nombres.required' => 'Los nombres son obligatorios',
                'nombres.letters_spaces' => 'Los nombres solo pueden incluir letras',
                'apellidos.required' => 'Los apellidos son obligatorios',
                'apellidos.letters_spaces' => 'Los apellidos solo pueden incluir letras',
                'genero.required' => 'El género es obligatorio',
                'genero.letters_spaces' => 'El género solo puede incluir letras',
                'direccion.required' => 'La dirección es obligatoria',
                'direccion.letters_dash_spaces_dot' => 'La dirección solo puede incluir letras, números, espacios, - y .',
                'celular.required' => 'El número de celular es obligatorio',
                'celular.only_numbers' => 'El número de celular solo puede incluir números',
                'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
                'fecha_nacimiento.numbers_with_dash' => 'La fecha de nacimiento solo puede incluir números y -',
                'estado_civil.required' => 'El estado civil es obligatorio',
                'estado_civil.letters_dash_spaces_dot' => 'El estado civil solo puede incluir letras',

                'email.required' => 'El correo electrónico es obligatorio',
                'email.unique' => 'El correo electrónico ya está en uso',
                'email.email_validator' => '150 caracteres como maximo. Unicamente letras, digitos y @/./-/_',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'profesion.required' => 'La profesión es obligatoria',
                'profesion.letters_dash_spaces_dot' => 'La profesión solo puede incluir letras',
                'cargo.required' => 'El cargo es obligatorio',
                'cargo.letters_dash_spaces_dot' => 'El cargo solo puede incluir letras',
                'area.required' => 'El área es obligatoria',
                'area.letters_spaces' => 'El área solo puede incluir letras',
                'estado.required' => 'El estado es obligatoria',
                'estado.letters_spaces' => 'El área solo puede incluir letras',
            ]);
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
            $user->email = $request->input('email');
            $user->estado = $request->input('estado', 'enable');
            $user->profesion = $request->input('profesion');
            $user->matricula_profesion = $request->input('matricula_profesion');
            $user->matricula_colegio = $request->input('matricula_colegio');
            $user->cargo = $request->input('cargo');
            $user->area = $request->input('area');

            if ($request->has('password') && !empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
            if ($request->hasFile('nuevaimagen')) {
                if ($user->imagen) {
                    Storage::disk('public')->delete($user->imagen);
                }
                $imagenPath = $request->file('nuevaimagen')->store('images', 'public');
                $user->imagen = $imagenPath;
            }
            $user->save();
            $user->syncRoles($request->input('roles'));

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizados exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error al actualizar usuario. Detalles: ' . $e->getMessage()]);
        }
    }
}
