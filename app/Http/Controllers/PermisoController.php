<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class PermisoController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderby('name','asc')->get();

        return view('admin.permissions.index', compact('permissions'));
    }
    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
            'details' => 'required',
        ]);

        Permission::create([
            'name' => $request->input('name'),
            'guard_name' => 'web',
            'details' => $request->input('details'),
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permiso creado exitosamente');
    }
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
    }


}
