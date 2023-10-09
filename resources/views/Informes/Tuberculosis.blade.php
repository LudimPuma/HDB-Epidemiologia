@extends('layout')
@section('content')
<div class="tables-wrapper">
    <br><br><br><br>
    <form action="{{ route('informe.Tuberculosis.E_N_I') }}" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 style="text-align: center">Resistencia Bacteriana de IAAS</h1>
            <div class="modal-body">
                <div class="form-group">
                    <label for="a">Año:</label>
                    <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Generar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>

</div>
@endsection
