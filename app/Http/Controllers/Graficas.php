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
        
        return response()->json(['message' => 'Imagen guardada con éxito.']);
    }
    public function saveNoLoadChart(Request $request)
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
        
        return response()->json(['message' => 'Imagen guardada con éxito.']);
    }
}
