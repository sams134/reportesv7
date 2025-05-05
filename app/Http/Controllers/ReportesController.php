<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;
use OpenAI;

class ReportesController extends Controller
{
    //
    protected $client;
    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }
    public function generateReport(Motor $motor){
       
        $user = auth()->user();
        $html = view('pdfs.reportePdf')->with([
            'motor' => $motor,
            'tecnico' => $user->name,
            'foto_final' => $motor->fotos->where('type', 100)->last(),
        ])
            ->render();
        $pdf = PDF::loadHTML($html)->setOption('load-error-handling', 'ignore') // Ignora los errores de carga
        ->setOption('load-error-handling', 'ignore')
        ->setOption('enable-local-file-access', true)
        ->setOption('no-stop-slow-scripts', true)
        ->setOption('javascript-delay', 5000);
    
      // 120 segundos en lugar de 10
      
        return $pdf->inline('reporte2.pdf');
        
    }
    public function generarComentario($datos)
    {
        $prompt = "Genera un comentario técnico basado en los siguientes datos de ajuste mecánico:\n";
        $prompt .= json_encode($datos, JSON_PRETTY_PRINT);

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo', // Puedes usar 'gpt-3.5-turbo' si prefieres
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un ingeniero mecánico experto en ajustes de rodamientos.'],
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        return $response['choices'][0]['message']['content'];
    }
   
}
