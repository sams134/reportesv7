<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;


class ReportesController extends Controller
{
    //
    protected $client;
    public function __construct() {}


    public function generateReport(Motor $motor)
    {
        $tmpTempChart = null;

        if (!empty($motor->temperaturas_path)) {
            $relative = ltrim($motor->temperaturas_path, '/');

            $fullPath = public_path('storage/' . $relative);

            if (file_exists($fullPath)) {
                $tmpTempChart = $fullPath;
            }
        }
        $user = auth()->user();

        $html = view('pdfs.reportePdf')->with([
            'motor' => $motor,
            'tecnico' => $user->name,
            'foto_final' => $motor->fotos->where('type', 100)->last(),
            'tmpTempChart' => $tmpTempChart,
        ])->render();

        $pdf = PDF::loadHTML($html)
            ->setOption('load-error-handling', 'ignore')
            ->setOption('enable-local-file-access', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 5000);

        // 1) Generar el PDF base (informe) en memoria
        $reportContent = $pdf->output();

        // 2) Guardarlo temporalmente para que FPDI pueda leerlo como archivo
        $tmpReportPath = storage_path('app/tmp_reporte_' . $motor->id . '_' . time() . '.pdf');
        file_put_contents($tmpReportPath, $reportContent);

        // 3) Buscar PDFs anexos desde documentos (por ahora: solo surge)
        //    OJO: esto asume que YA tienes la columna 'seccion' en documentos.
        $docsToAppend = $motor->documentos()
            ->whereIn('seccion', ['densidades', 'surge', 'vibraciones', 'balanceo'])
            ->orderByRaw("FIELD(seccion, 'surge', 'vibraciones')") // primero surge, luego vibraciones
            ->orderBy('created_at')
            ->get();

        // 4) Merge con FPDI
        $fpdi = new Fpdi();


        // helper para agregar todas las páginas de un PDF al fpdi
        $appendPdf = function (string $path) use ($fpdi) {
            if (!file_exists($path)) return;

            try {
                $pageCount = $fpdi->setSourceFile($path);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $tplId = $fpdi->importPage($pageNo);
                    $size = $fpdi->getTemplateSize($tplId);

                    $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $fpdi->useTemplate($tplId);
                }
            } catch (\Throwable $e) {
                // si un PDF está corrupto o no es compatible, lo saltamos sin tumbar el informe
                // (puedes loggear si quieres)
            }
        };

        // primero el informe base
        $appendPdf($tmpReportPath);

        // luego anexos surge
        foreach ($docsToAppend as $doc) {
            // documento guarda algo tipo "/uploads/.../Documentos/archivo.pdf"
            $relative = ltrim($doc->documento, '/');

            // ruta real al archivo en disco usando el disk public (lo más confiable)
            $fullPath = public_path('storage/' . $relative);

            $appendPdf($fullPath);
        }

        // limpiar temp
        @unlink($tmpReportPath);

        // 5) devolver el pdf merged inline (sin escribir archivo final)
        $mergedContent = $fpdi->Output('S');

        return response($mergedContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="informe_' . $motor->id . '.pdf"',
        ]);
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
