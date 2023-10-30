@extends('layout')

@section('content')
    <div class="container">
        <h1 class="text-center">Crear Permiso</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('permissions.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nombre del Permiso:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="details">Detalles del Permiso:</label>
                <input type="text" name="details" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Permiso</button>
        </form>
    </div>
@endsection
