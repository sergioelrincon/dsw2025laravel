<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar mensaje</title>
</head>
<body>
    <h1>Enviar mensaje</h1>

    {{-- Mostramos errores de validación --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mostramos mensaje de éxito si existe --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('mensaje.store') }}" method="POST">
        @csrf

        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"><br><br>

        <label for="email">Correo electrónico:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje">{{ old('mensaje') }}</textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
