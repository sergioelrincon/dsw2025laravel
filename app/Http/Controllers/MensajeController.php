<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MensajeController extends Controller
{
    // Muestra el formulario
    public function create()
    {
        // Retornamos la vista del formulario
        return view('mensaje.create');
    }

    public function store(Request $request)
    {
        // Validamos los datos recibidos
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'email' => 'required|email',
            'mensaje' => 'required|string|max:500',
        ]);

        $linea = '"' . $datos['nombre'] . '";"' . $datos['email'] . '";"' . $datos['mensaje'] . "\"\n";

        /*
        Con storage_path obtenemos la ruta absoluta del directorio storage/ dentro del proyecto. Esto es útil porque Laravel no asume directamente que puedas escribir en cualquier parte del sistema de archivos (por seguridad y buenas prácticas).
        Laravel tiene una carpeta especial llamada storage/ para guardar archivos generados por la aplicación
        Dentro de storage/ suele haber un subdirectorio llamado app/, que es ideal para guardar este tipo de ficheros de trabajo. Pero si usas simplemente un nombre de archivo como "mensajes.csv", Laravel lo buscará o creará en la raíz del proyecto o según el path desde donde se ejecute el script, lo que puede generar errores inesperados o problemas de permisos.
        */
        file_put_contents(storage_path('app/mensajes.csv'), $linea, FILE_APPEND);

        // Redirigimos de vuelta al formulario con un mensaje de éxito. Es un helper de Laravel que crea una respuesta de redirección. Es un helper de Laravel que crea una respuesta de redirección.
        // with('status', '...') añade un dato temporal a la sesión que estará disponible solo en la siguiente solicitud. Este dato se conoce como mensaje flash.
        return redirect()->route('mensaje.create')->with('status', 'Mensaje guardado correctamente.');
    }

    public function index()
    {
        // Ruta absoluta al archivo mensajes.csv
        $ruta = storage_path('app/mensajes.csv');
        $mensajes = [];

        if (file_exists($ruta)) {
            // Leemos todas las líneas del archivo
            // FILE_IGNORE_NEW_LINES para no incluir saltos de línea
            // FILE_SKIP_EMPTY_LINES para ignorar líneas vacías
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

        // Pasamos los mensajes a la vista
        // compact('mensajes') crea un array con la variable $mensajes
        return view('mensaje.index', compact('mensajes'));
    }

}
