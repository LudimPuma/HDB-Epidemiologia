<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
            return view('admin.roles.show', compact('rol', 'permissions'));
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
        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = 'web'; // Puedes establecer el guard_name como sea necesario
        $role->details = $request->input('details'); // Asegúrate de obtener los detalles del formulario
        $role->save();

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }



    public function edit($id)
    {
        $rol = Role::find($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('rol', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $rol = Role::find($id);

        $rol->permissions()->sync($request->input('permissions', []));

        return redirect()->route('roles.index', $rol)->with('success', 'Rol actualizado exitosamente');
    }


}
