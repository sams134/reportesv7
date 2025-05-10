<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class Graficas extends Controller
{
    //
    /*   public function saveChart(Request $request)
    {
        
        $request->validate([
            'image' => 'required|string',
            'motor_id' => 'required|exists:motores,id_motor',
        ]);

        // Obtener el motor
        $motor = Motor::find($request->motor_id);

        // Decodificar la imagen base64
        $imageData = $request->image;
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = base64_decode($imageData);

        // Guardar la imagen como BLOB en la base de datos
        $motor->temperaturas = $imageData;
        $motor->save();

        return response()->json(['message' => 'Imagen guardada con éxito.']);
    } */

    public function saveTemperatureChart(Request $request)
    {

        $request->validate([
            'image' => 'required',
            'motor_id' => 'required',
        ]);
        $motor = Motor::find($request->motor_id);

        // Decodificar la imagen base64
        $imageData = $request->image;
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = base64_decode($imageData);

        // Guardar la imagen como BLOB en la base de datos
        $motor->temperaturas = $imageData;
        $motor->save();

     
        return response()->json([
            'message' => utf8_encode('Imagen guardada con exito.')
        ]);
    }
    public function saveNoLoadChart(Request $request)
    {
        // 1) Validamos que 'image' viene como string
        $request->validate([
            'image'    => 'required|string',
            'motor_id' => 'required|exists:motors,id_motor',
        ]);

        // 2) Cargamos el motor y su prueba de no-load
        $motor = Motor::with('noLoadTest')->findOrFail($request->motor_id);
        $noLoadTest = $motor->noLoadTest;
        if (! $noLoadTest) {
            return response()->json([
                'message' => 'No Load Test no encontrado para este motor.'
            ], 404);
        }

        // 3) Limpiamos y decodificamos la cadena Base64
        //    Quitamos cualquier prefijo data URI (png, jpeg, etc.)
        $base64 = $request->input('image');
        // Ejemplo de regex que cubre distintos formatos
        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
        $imageData = base64_decode($base64);
        if ($imageData === false) {
            return response()->json([
                'message' => 'Error al decodificar la imagen Base64.'
            ], 422);
        }

        // 4) Asignamos el binario al campo BLOB y guardamos
        $noLoadTest->graph_fl = $imageData;
        $noLoadTest->save();

        return response()->json([
            'message' => 'Imagen No Load Test guardada con éxito.'
        ]);
    }
}
