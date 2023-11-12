@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 offset-md">
            <div class="card">
                <br>
                <h2 class="text-center">Users</h2>
                <div class="text-center">

                    <a class="btn btn-success mb-3" href="{{ route('usuarios.create') }}">Crear</a>

                </div>
                <div class="card-body">
                    <table id="dataTable"  class="table text-center mt-3 table-light table-hover table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->persona->nombres }} {{ $user->persona->apellidos}}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            {{ $role->name }}
                                            @if (!$loop->last)
                                                , <!-- Agrega una coma si no es el último rol -->
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $user->estado}}</td>
                                    <td>
                                        <a href="{{ route('usuarios.show', $user->id) }}"style="text-decoration: none;">
                                            <svg width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="color: #0074FF; fill: #0074FF;" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='#0074FF';">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('usuarios.edit', $user->id) }}"style="text-decoration: none;">
                                            <svg width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" style="color: #FFC107; fill: #FFC107;" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='#FFC107';">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
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
