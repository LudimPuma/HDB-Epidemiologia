@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 offset-md">
            <div class="card">
                <br>
                <h2 class="text-center">List of Permits</h2>
                <div class="text-center">

                    <a class="btn btn-success mb-3" href="{{ route('permissions.create') }}">Crear</a>

                </div>
                {{-- <a href="{{ route('permissions.clear-spatie-cache') }}" class="btn btn-danger">Borrar Cache de Spatie</a> --}}

                <div class="card-body">
                    <table id="dataTable"  class="table text-center mt-3 table-light table-hover table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->details }}</td>
                                    <td>
                                        <a href="{{ route('permissions.show', $permission->id) }}" style="text-decoration: none;">
                                            <svg width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="color: #0074FF; fill: #0074FF;" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='#0074FF';">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
