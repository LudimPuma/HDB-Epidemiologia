<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderby('name','asc')->get();
        return view('admin.roles.index', compact('roles'));
    }
    public function show($id)
    {
        $rol = Role::find($id);

        if ($rol) {
            $permissions = Permission::all();
            $assignedPermissions = $rol->permissions; // Obtener solo los permisos asignados a este rol

            return view('admin.roles.show', compact('rol', 'permissions', 'assignedPermissions'));
        } else {
            return redirect()->route('roles.index')->with('error', 'Rol no encontrado');
        }
    }

    public function create()
    {
        return view('admin.roles.create');
    }
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'name' => ['required','letters_spaces','unique:roles'],
                'details' => 'required|letters_dash_spaces_dot',
            ], [
                'name.required' => 'El nombre es obligatorio',
                'name.unique' => 'El nombre del rol ya esta en uso',
                'name.letters_spaces' => 'El nombre solo puede incluir letras',
                'details.required' => 'El detalle es obligatorio',
                'details.letters_dash_spaces_dot' => 'El detalle solo puede incluir letras, números y -/./()/#',
            ]);
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = 'web';
            $role->details = $request->input('details');
            $role->save();
            return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
        } catch(QueryException $e) {
            return redirect()->back()->withErrors(['Error al ingresar roles. Detalles: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $rol = Role::find($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('rol', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        try{
            $rol = Role::find($id);
            $this->validate($request, [
                'name' => 'required','letters_spaces', Rule::unique('roles')->ignore($rol->id),
                'details' => 'required|letters_dash_spaces_dot',
            ], [
                'name.required' => 'El nombre es obligatorio',
                'name.unique' => 'El nombre del rol ya esta en uso',
                'name.letters_spaces' => 'El nombre solo puede incluir letras',
                'details.required' => 'El detalle es obligatorio',
                'details.letters_dash_spaces_dot' => 'El detalle solo puede incluir letras, números y -/./()/#',
            ]);
            $rol->permissions()->sync($request->input('permissions', []));
            $rol->update([
                'name' => $request->input('name'),
                'details' => $request->input('details'),
            ]);
            return redirect()->route('roles.index', $rol)->with('success', 'Rol actualizado exitosamente');

        } catch(QueryException $e) {
            return redirect()->back()->withErrors(['Error al ingresar roles. Detalles: ' . $e->getMessage()]);
        }
    }
}
