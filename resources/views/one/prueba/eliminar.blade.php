eliminar
<!DOCTYPE html>
<html>
<head>
    <title>Detalle del Agente Causal</title>
</head>
<body>
    <h1>Detalle del Agente Causal</h1>

    <p><strong>Nombre:</strong> {{ $agente->nombre }}</p>

    <form method="POST" action="{{ route('agente.destroy', $agente->cod_agente_causal) }}">
    @csrf
    @method('DELETE')

    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-danger">Eliminar</a>
    </form>
</body>
</html>
