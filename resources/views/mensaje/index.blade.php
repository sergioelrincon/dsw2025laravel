<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes recibidos</title>
</head>
<body>
    <h1>Mensajes recibidos</h1>

    @if (count($mensajes) > 0)
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mensajes as $mensaje)
                    <tr>
                        <td>{{ $mensaje['nombre'] }}</td>
                        <td>{{ $mensaje['email'] }}</td>
                        <td>{{ $mensaje['mensaje'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se han recibido mensajes aún.</p>
    @endif
</body>
</html>
