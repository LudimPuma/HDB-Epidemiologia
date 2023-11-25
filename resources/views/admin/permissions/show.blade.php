@extends('layout')
@section('title', 'Administración | Permisos | Vista')
@section('guide', 'Administración / Permisos / Vista')
@section('content')
    <h1>Detalles del Permiso</h1>
    <p><strong>Name:</strong> {{ $permission->name }}</p>
    <p><strong>Details:</strong> {{ $permission->details }}</p>
@endsection
