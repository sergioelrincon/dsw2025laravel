<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MensajeController extends Controller
{
    // Muestra el formulario
    public function create()
    {
        return view('mensaje.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'email' => 'required|email',
            'mensaje' => 'required|string|max:300',
        ]);

        // Formato CSV: "nombre";"email";"mensaje"
        $linea = sprintf(
            "\"%s\";\"%s\";\"%s\"\n",
            $validated['nombre'],
            $validated['email'],
            str_replace(["\r", "\n"], ' ', $validated['mensaje']) // Limpieza básica
        );

        // Guardar en fichero
        $ruta = storage_path('app/mensajes.csv');
        \Illuminate\Support\Facades\File::append($ruta, $linea);

        // Redirigir con mensaje
        return redirect()->route('mensaje.create')->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }


    public function index()
    {
        $ruta = storage_path('app/mensajes.csv');
        $mensajes = [];

        if (file_exists($ruta)) {
            $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lineas as $linea) {
                // Eliminamos comillas y separamos por punto y coma
                $campos = str_getcsv($linea, ';', '"');

                if (count($campos) === 3) {
                    $mensajes[] = [
                        'nombre' => $campos[0],
                        'email' => $campos[1],
                        'mensaje' => $campos[2],
                    ];
                }
            }
        }

        return view('mensaje.index', compact('mensajes'));
    }

}
