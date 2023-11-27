@extends('layout')
@section('title', 'Administración | Roles | Agregar')
@section('guide', 'Administración / Roles / Agregar')
@section('content')
<div class="container bg-white rounded p-4 shadow-lg" >
    <div class="container bg-light rounded p-4 shadow-lg">
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8">
                <div class="row">
                    <div class="col-md-8 mx-auto mb-4">
                        <div class="form-group">
                            <label for="name"><strong><small>Nombre del Rol</small></strong></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var errorMessage = @json($message);
                                        if (errorMessage) {
                                            Swal.fire('Error', errorMessage, 'error');
                                        }
                                    });
                                </script>
                            @enderror
                        </div>
                    </div>
                </div>
                <input type="hidden" name="guard_name" id="guard_name" class="form-control" value="web">
                <div class="row">
                    <div class="col-md-8 mx-auto mb-4">
                        <div class="form-group">
                            <label for="details"><strong><small>Detalles</small></strong></label>
                            <input type="textarea" name="details" id="details" class="form-control" value="{{ old('details') }}" required>
                            @error('details')
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var errorMessage = @json($message);
                                        if (errorMessage) {
                                            Swal.fire('Error', errorMessage, 'error');
                                        }
                                    });
                                </script>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2 d-grid gap-2 col-6 mx-auto">
                {{-- <button type="submit" class="btn btn-primary">Crear Rol</button> --}}
                <button id="submit-button" type="submit" class="btn btn-success ">Guardar</button>
            </div>
        </form>
    </div>
</div>

@endsection
