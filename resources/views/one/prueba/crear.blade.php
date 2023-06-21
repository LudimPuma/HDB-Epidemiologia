crear
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Agente Causal</title>
</head>
<body>
    <h1>Agregar Agente Causal</h1>

    <form method="POST" action="{{ route('agente.store') }}">
        @csrf

        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>

