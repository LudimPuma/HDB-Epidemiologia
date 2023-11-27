@extends('layout')
@section('title', 'Administración | Roles | Editar')
@section('guide', 'Administración / Roles / Editar')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container bg-white rounded p-4 shadow-lg">
            <div class="container bg-light rounded p-4 shadow-lg">
                {!! Form::model($rol, ['route' => ['roles.update', $rol], 'method' => 'put']) !!}
                    <div class="card-style mb-30 p-4 text-dark shadow-lg" style="background-color: #9ad0a8">
                        <div class="row">
                            <div class="col-md-8 mx-auto mb-3">
                                <div class="form-group">
                                    {!! html_entity_decode(Form::label('name', '<strong><small>Nombre</small></strong>')) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
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
                        <div class="row">
                            <div class="col-md-8 mx-auto mb-3">
                                <div class="form-group">
                                    {!! html_entity_decode(Form::label('details', '<strong><small>Detalles</small></strong>')) !!}
                                    {!! Form::text('details', null, ['class' => 'form-control']) !!}
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
                        <div class="row">
                            @foreach (array_chunk($permissions->toArray(), ceil(count($permissions) / 2)) as $chunk)
                                <div class="col-md-6">
                                    @foreach ($chunk as $permission)
                                        <div class="form-group">
                                            <label>
                                                {!! Form::checkbox('permissions[]', $permission['id'], $rol->hasPermissionTo($permission['id']), ['class' => 'mr-1']) !!}
                                                {{ $permission['details'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        {!! Form::submit('Actualizar Rol', ['class' => 'btn btn-success']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
