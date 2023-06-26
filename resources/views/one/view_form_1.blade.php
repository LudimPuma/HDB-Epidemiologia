@extends('layout')
@section('content')
<div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-primary" onclick="window.location='{{ route('historial') }}'">
            Formulario IAAS
        </button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-secondary" >
            Generar pdf
        </button>
    </div>
</div>
@endsection
