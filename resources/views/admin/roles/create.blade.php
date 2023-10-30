@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Crear Rol</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('roles.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nombre del Rol</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <input type="hidden" name="guard_name" id="guard_name" class="form-control" value="web">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <input type="textarea" name="details" id="details" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Crear Rol</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
