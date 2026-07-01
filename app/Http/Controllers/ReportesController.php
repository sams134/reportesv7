<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;
use App\Models\Foto;


class ReportesController extends Controller
{
    //
    protected $client;
    public function __construct() {}


    public function generateReport(Motor $motor)
    {
        $motor->load([
            'cliente',
            'infoMotor',
            'tipoequipo',
            'fotos',
            'temps',
            'documentos',
            'noLoadTest',
            'ajustes.rodamiento',
            'ajustes.rodamientoMarca',
            'ajustes.grasa',
        ]);

        $user = auth()->user();

        /*
    |--------------------------------------------------------------------------
    | Estado del informe
    |--------------------------------------------------------------------------
    */
        $isPreliminar = empty($motor->fin);

        /*
    |--------------------------------------------------------------------------
    | Fotos seguras
    |--------------------------------------------------------------------------
    | Foto inicial: primera foto disponible.
    | Foto final: type 100 si existe; si no existe, usar inicial.
    */
        $fotoInicial = $motor->fotos->first();
        $fotoFinalReal = $motor->fotos->where('type', Foto::FIN)->last();
        $fotoFinal = $fotoFinalReal ?: $fotoInicial;

        $defaultImagePath = public_path('img/default-avatar.png');

        $fotoInicialPath = $this->photoPdfPath($fotoInicial, $defaultImagePath);
        $fotoFinalPath = $this->photoPdfPath($fotoFinal, $fotoInicialPath);

        /*
    |--------------------------------------------------------------------------
    | Temperaturas
    |--------------------------------------------------------------------------
    */
        $tmpTempChart = null;

        if (!empty($motor->temperaturas_path)) {
            $relative = ltrim($motor->temperaturas_path, '/');
            $fullPath = public_path('storage/' . $relative);

            if (file_exists($fullPath)) {
                $tmpTempChart = $fullPath;
            }
        }

        $termografias = collect([71, 72, 73])
            ->mapWithKeys(function ($type) use ($motor) {
                $foto = $motor->fotos->where('type', $type)->last();

                return [
                    $type => [
                        'foto' => $foto,
                        'path' => $this->photoPdfPath($foto),
                    ],
                ];
            })
            ->toArray();

        $hasTermografias = collect($termografias)
            ->filter(fn($item) => !empty($item['path']))
            ->isNotEmpty();

        $hasTemperaturas =
            $motor->temps->count() > 0 ||
            $tmpTempChart ||
            $hasTermografias ||
            !empty($motor->temperaturas_comentario);

        /*
    |--------------------------------------------------------------------------
    | Amperajes / No Load
    |--------------------------------------------------------------------------
    */
        $nl = $motor->noLoadTest;

        $hasAmperajes = $nl &&
            $nl->amps_prueba_A !== null &&
            $nl->amps_prueba_B !== null &&
            $nl->amps_prueba_C !== null &&
            $nl->volts_prueba_A !== null &&
            $nl->volts_prueba_B !== null &&
            $nl->volts_prueba_C !== null;

        $noLoadGraphPath = null;

        if (!empty($nl?->graph_fl)) {
            $relative = ltrim($nl->graph_fl, '/');

            if (Storage::disk('public')->exists($relative)) {
                $noLoadGraphPath = Storage::disk('public')->path($relative);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Rodamientos / alojamientos / ejes
    |--------------------------------------------------------------------------
    */
        $rodamientos = $this->buildRodamientosData($motor);
        $hasRodamientos = $rodamientos->count() > 0;

        /*
    |--------------------------------------------------------------------------
    | Fotos seleccionadas para informe
    |--------------------------------------------------------------------------
    */
        $fotosInforme = $motor->fotos
            ->where('addToReport', 1)
            ->map(function ($foto) {
                $foto->pdf_path = $this->publicDiskPath($foto->foto);
                return $foto;
            })
            ->filter(fn($foto) => !empty($foto->pdf_path))
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Render PDF base
    |--------------------------------------------------------------------------
    */
        $html = view('pdfs.reportePdf')->with([
            'motor' => $motor,
            'tecnico' => $user->name,

            'isPreliminar' => $isPreliminar,
            'tituloInforme' => $isPreliminar
                ? 'INFORME PRELIMINAR DE REPARACIÓN'
                : 'REPORTE TÉCNICO DE REPARACIÓN',
            'tituloHeader' => $isPreliminar
                ? 'INFORME PRELIMINAR DE MANTENIMIENTO'
                : 'INFORME TÉCNICO DE MANTENIMIENTO',
            'fechaFinTexto' => $isPreliminar
                ? 'PENDIENTE'
                : \Carbon\Carbon::parse($motor->fin)->format('d/m/Y'),

            'fotoInicial' => $fotoInicial,
            'fotoFinal' => $fotoFinal,
            'fotoInicialPath' => $fotoInicialPath,
            'fotoFinalPath' => $fotoFinalPath,

            'tmpTempChart' => $tmpTempChart,
            'termografias' => $termografias,
            'hasTemperaturas' => $hasTemperaturas,

            'hasAmperajes' => $hasAmperajes,
            'noLoadGraphPath' => $noLoadGraphPath,

            'rodamientos' => $rodamientos,
            'hasRodamientos' => $hasRodamientos,

            'fotosInforme' => $fotosInforme,
        ])->render();

        $pdf = PDF::loadHTML($html)
            ->setOption('load-error-handling', 'ignore')
            ->setOption('load-media-error-handling', 'ignore')
            ->setOption('enable-local-file-access', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 5000);

        $reportContent = $pdf->output();

        $tmpReportPath = storage_path('app/tmp_reporte_' . $motor->id_motor . '_' . time() . '.pdf');
        file_put_contents($tmpReportPath, $reportContent);

        $docsToAppend = $motor->documentos()
            ->whereIn('seccion', ['densidades', 'balanceo', 'surge', 'vibraciones'])
            ->orderByRaw("FIELD(seccion, 'densidades', 'balanceo', 'surge', 'vibraciones')")
            ->orderBy('created_at')
            ->get();

        $fpdi = new Fpdi();

        $appendPdf = function (string $path) use ($fpdi) {
            if (!file_exists($path)) {
                return;
            }

            try {
                $pageCount = $fpdi->setSourceFile($path);

                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $tplId = $fpdi->importPage($pageNo);
                    $size = $fpdi->getTemplateSize($tplId);

                    $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $fpdi->useTemplate($tplId);
                }
            } catch (\Throwable $e) {
                // PDF corrupto o no compatible: se omite sin tumbar el informe.
            }
        };

        $appendPdf($tmpReportPath);

        foreach ($docsToAppend as $doc) {
            $relative = ltrim($doc->documento, '/');
            $fullPath = public_path('storage/' . $relative);

            $appendPdf($fullPath);
        }

        @unlink($tmpReportPath);

        $mergedContent = $fpdi->Output('S');

        return response($mergedContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="informe_' . $motor->id_motor . '.pdf"',
        ]);
    }
    private function publicStorageImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $relative = ltrim($path, '/');
        $fullPath = public_path('storage/' . $relative);

        return file_exists($fullPath) ? $fullPath : null;
    }

    private function numericValues(array $values)
    {
        return collect($values)
            ->filter(fn($value) => $value !== null && $value !== '' && is_numeric($value))
            ->values();
    }

    private function buildRodamientosData(Motor $motor)
    {
        return collect([0, 1])->map(function ($lado) use ($motor) {
            $rodInicial = $motor->ajustes
                ->where('carga_opuesto', $lado)
                ->where('initial_final', 0)
                ->first();

            $rodFinal = $motor->ajustes
                ->where('carga_opuesto', $lado)
                ->where('initial_final', 1)
                ->first();

            if (!$rodInicial || !$rodFinal || !$rodFinal->rodamiento) {
                return null;
            }

            $cojineteVals = $this->numericValues([
                $rodFinal->p,
                $rodFinal->q,
                $rodFinal->r,
            ]);

            $alojInicialVals = $this->numericValues([
                $rodInicial->ax,
                $rodInicial->ay,
                $rodInicial->bx,
                $rodInicial->by,
                $rodInicial->cx,
                $rodInicial->cy,
            ]);

            $alojFinalVals = $this->numericValues([
                $rodFinal->ax,
                $rodFinal->ay,
                $rodFinal->bx,
                $rodFinal->by,
                $rodFinal->cx,
                $rodFinal->cy,
            ]);

            $ejeInicialVals = $this->numericValues([
                $rodInicial->e1,
                $rodInicial->e2,
                $rodInicial->e3,
            ]);

            $ejeFinalVals = $this->numericValues([
                $rodFinal->e1,
                $rodFinal->e2,
                $rodFinal->e3,
            ]);

            /*
         * Si faltan datos críticos, no se genera la página de ese lado.
         */
            if (
                $cojineteVals->count() < 3 ||
                $alojInicialVals->count() < 4 ||
                $alojFinalVals->count() < 4 ||
                $ejeInicialVals->count() < 2 ||
                $ejeFinalVals->count() < 2
            ) {
                return null;
            }

            $rodamiento = $rodFinal->rodamiento;

            return [
                'codigo' => $rodamiento->designacion ?? 'N/D',
                'juego_radial' => $rodFinal->juego_radial == 1 ? 'Ninguno' : ($rodFinal->juego_radial == 2 ? 'C3' : 'C4'),
                'marca' => $rodFinal->rodamientoMarca->name ?? 'N/D',
                'sellos' => $rodFinal->sellos == 1 ? 'Ninguno' : ($rodFinal->sellos == 2 ? 'Metal (ZZ)' : 'Hule (2RS)'),
                'jaula' => $rodFinal->jaula == 1 ? 'Metal' : ($rodFinal->jaula == 2 ? 'Bronce' : 'Poliamida'),
                'grasa' => $rodFinal->grasa->name ?? 'N/D',
                'img' => $rodamiento->tipo == 1 ? public_path('img/bolas.png') : public_path('img/rodillos.png'),
                'tipo' => $rodamiento->tipo,
                'medidas' => $rodamiento,
                'title' => $lado == 0 ? 'Lado de Carga' : 'Lado Opuesto',

                'rod' => $rodFinal,
                'rodInicial' => $rodInicial,

                'cojineteMax' => $cojineteVals->max(),
                'cojineteMin' => $cojineteVals->min(),

                'alojamientoInicialMax' => $alojInicialVals->max(),
                'alojamientoInicialMin' => $alojInicialVals->min(),
                'alojamientoFinalMax' => $alojFinalVals->max(),
                'alojamientoFinalMin' => $alojFinalVals->min(),

                'ejeInicialMax' => $ejeInicialVals->max(),
                'ejeInicialMin' => $ejeInicialVals->min(),
                'ejeFinalMax' => $ejeFinalVals->max(),
                'ejeFinalMin' => $ejeFinalVals->min(),
            ];
        })->filter()->values();
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
    private function publicDiskPath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $relative = ltrim($path, '/');

        /*
     * Por si algún registro viene guardado como storage/uploads/...
     */
        if (str_starts_with($relative, 'storage/')) {
            $relative = substr($relative, strlen('storage/'));
        }

        if (!Storage::disk('public')->exists($relative)) {
            return null;
        }

        return Storage::disk('public')->path($relative);
    }

    private function photoPdfPath($foto, ?string $fallback = null): ?string
    {
        $path = $this->publicDiskPath($foto?->foto);

        return $path ?: $fallback;
    }
}
