<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Trabajo - ADFix</title>
</head>
<body>

<h1>Nuevo Trabajo</h1>

<form method="POST" action="{{ route('repairs.store') }}">
    @csrf

    <h3>Cliente existente</h3>
    <select name="client_id">
        <option value="">-- Nuevo cliente --</option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}">
                {{ $client->name }} ({{ $client->phone }})
            </option>
        @endforeach
    </select>

    <h3>O crear cliente</h3>
    <input type="text" name="client_name" placeholder="Nombre">
    <input type="text" name="client_phone" placeholder="Teléfono">

    <hr>

    <input type="text" name="device" placeholder="Equipo" required><br><br>
    <textarea name="issue" placeholder="Falla" required></textarea><br><br>

    <input type="number" step="0.01" name="estimated_price" placeholder="Presupuesto $" required><br><br>

    <select name="status">
        <option value="pendiente">Pendiente</option>
        <option value="en_proceso">En proceso</option>
        <option value="completado">Completado</option>
    </select><br><br>

    <input type="date" name="received_at" value="{{ date('Y-m-d') }}"><br><br>

    <button type="submit">Guardar trabajo</button>
</form>

</body>
</html>
