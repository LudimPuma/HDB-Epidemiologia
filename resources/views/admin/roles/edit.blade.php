@extends('layout')

@section('content')
    {{-- <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Editar Rol</div>
                    <div class="card-body">
                        <form action="{{ route('roles.update', $rol->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nombre del Rol:</label>
                                <input type="text" name="name" value="{{ $rol->name }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Permisos:</label>
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            {{ $rol->permissions->contains($permission) ? 'checked' : '' }}
                                            class="form-check-input"
                                        >
                                        <label class="form-check-label">{{ $permission->details }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Rol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <h4 class="text-center">{{$rol->name}}</h4>
    {!! Form::model($rol, ['route' => ['roles.update', $rol], 'method'=>'put']) !!}
        @foreach ($permissions as $permission)
        <div>
            <label>
                {{-- {!! Form::checkbox('permission[]', $permission->id, $rol->hasPermissionTo($permission->id) ? : false, ['class'=>'mr-1']) !!} --}}
                {!! Form::checkbox('permissions[]', $permission->id, $rol->hasPermissionTo($permission->id), ['class'=>'mr-1']) !!}
                    {{$permission->details}}
            </label>
        </div>
        @endforeach
        {!! Form::submit('Asignar permiso', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
