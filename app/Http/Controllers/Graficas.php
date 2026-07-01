<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Motor;

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
            'image'    => 'required|string',
            'motor_id' => 'required|exists:motors,id_motor',
        ]);

        $motor = Motor::findOrFail($request->motor_id);

        // Quitar prefijo data URI
        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $request->input('image'));

        $imageData = base64_decode($base64);
        if ($imageData === false) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al decodificar la imagen Base64.'
            ], 422);
        }

        // Guardar en TU estructura
        $folder = "uploads/{$motor->year}-{$motor->os}/temperaturas";
        $relativePath = "{$folder}/temperaturas.png"; // siempre sobrescribe

        Storage::disk('public')->makeDirectory($folder);
        Storage::disk('public')->put($relativePath, $imageData);

        // Guardar path en DB (ya lo estás usando)
        $motor->temperaturas_path = $relativePath;
        $motor->save();

        return response()->json([
            'ok' => true,
            'message' => 'Gráfica guardada con éxito.',
            'path' => $relativePath,
            'url'  => asset('storage/' . ltrim($relativePath, '/')),
        ]);
    }




    public function saveNoLoadChart(Request $request)
    {
        $request->validate([
            'image'    => 'required|string',
            'motor_id' => 'required|exists:motors,id_motor',
        ]);

        $motor = Motor::with('noLoadTest')
            ->where('id_motor', $request->motor_id)
            ->firstOrFail();

        if (!$motor->noLoadTest) {
            return response()->json([
                'ok' => false,
                'message' => 'No Load Test no encontrado para este motor.',
            ], 404);
        }

        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $request->input('image'));
        $imageData = base64_decode($base64);

        if ($imageData === false) {
            return response()->json([
                'ok' => false,
                'message' => 'Base64 inválido.',
            ], 422);
        }

        $folder = "uploads/{$motor->year}-{$motor->os}/no_load";
        $relativePath = "{$folder}/no_load.png";

        \Storage::disk('public')->makeDirectory($folder);
        \Storage::disk('public')->put($relativePath, $imageData);

        $motor->noLoadTest->graph_fl = $relativePath;
        $motor->noLoadTest->last_graph_saved_by = auth()->id();
        $motor->noLoadTest->save();

        return response()->json([
            'ok' => true,
            'message' => 'Gráfica No Load guardada con éxito.',
            'path' => $relativePath,
            'url' => asset('storage/' . $relativePath),
        ]);
    }


    public function getTemperatureChart($motor_id)
    {
        $motor = Motor::where('id_motor', $motor_id)->firstOrFail();

        if (!$motor->temperaturas_path) {
            return response('', 404);
        }

        $relativePath = ltrim($motor->temperaturas_path, '/');

        if (!Storage::disk('public')->exists($relativePath)) {
            return response('', 404);
        }

        return response(Storage::disk('public')->get($relativePath), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }
}
