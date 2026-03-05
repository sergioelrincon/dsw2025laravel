<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MensajeResource;
use Illuminate\Http\Request;
use App\Models\Message;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos todos los mensajes de la base de datos
        $mensajes = Message::all();

        // Retornamos los mensajes en formato JSON.
        return MensajeResource::collection($mensajes); // Usamos el recurso para transformar los datos antes de enviarlos al cliente.

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validamos los datos recibidos
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'email' => 'required|email',
            'mensaje' => 'required|string|max:500',
        ]);

        // Insertamos un nuevo mensaje en la base de datos.
        $mensaje = new Message();
        $mensaje->name = $datos['nombre'];
        $mensaje->email = $datos['email'];
        $mensaje->message = $datos['mensaje'];
        $mensaje->save();

        // Retornamos el mensaje creado en formato JSON con un código de estado 201 (creado).
        return response()->json([
            'status' => 'success',
            'data' => $mensaje
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
