<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;


class CotizacionPdfController extends Controller
{

    public function downloadPdf(Request $request, Cotizacion $cotizacion)
    {
        $cotizacion->load([
            'cliente.info_cliente',
            'motor.infoMotor',
            'motor.fotos',
            'contactosCotizacion',
            'itemsCotizacion',
            'creadoPor',
            'unificadaDetalles.items',
            'unificadaDetalles.cotizacionOrigen.motor.infoMotor',
            'pdfsAntesItems',
            'pdfsDespuesItems',

        ]);

        $filename = $this->nombreArchivoCotizacionPdf($cotizacion);

        $tmpDir = storage_path('app/tmp/cotizaciones/' . Str::uuid());
        File::ensureDirectoryExists($tmpDir);

        $inicioPath = $tmpDir . '/01_inicio.pdf';
        $itemsPath = $tmpDir . '/03_items.pdf';
        $terminosPath = $tmpDir . '/05_terminos.pdf';
        $finalPath = $tmpDir . '/cotizacion_final.pdf';

        $data = $this->dataPdfCotizacion($cotizacion);

        /*
     * 1. Portada + carta
     */
        PDF::loadView('pdfs.cotizaciones.portada1', array_merge($data, [
            'seccionPdf' => 'inicio',
        ]))
            ->setPaper('letter')
            ->save($inicioPath);

        /*
     * 2. Items + totales + información adicional
     */
        PDF::loadView('pdfs.cotizaciones.portada1', array_merge($data, [
            'seccionPdf' => 'items',
        ]))
            ->setPaper('letter')
            ->save($itemsPath);

        /*
     * 3. Términos, solo si aplica
     */
        if ($cotizacion->incluir_terminos_garantias) {
            PDF::loadView('pdfs.cotizaciones.portada1', array_merge($data, [
                'seccionPdf' => 'terminos',
            ]))
                ->setPaper('letter')
                ->save($terminosPath);
        }

        /*
     * 4. Orden final del PDF
     */
        $paths = [];

        $paths[] = $inicioPath;

        foreach ($this->pathsPdfsAdjuntosCotizacion($cotizacion, 'antes_items') as $path) {
            $paths[] = $path;
        }

        $paths[] = $itemsPath;

        foreach ($this->pathsPdfsAdjuntosCotizacion($cotizacion, 'despues_items') as $path) {
            $paths[] = $path;
        }

        if ($cotizacion->incluir_terminos_garantias && file_exists($terminosPath)) {
            $paths[] = $terminosPath;
        }

        $this->unirPdfs($paths, $finalPath);

        return response()
            ->file($finalPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ])
            ->deleteFileAfterSend(true);
    }
    private function dataPdfCotizacion(Cotizacion $cotizacion): array
    {
        return [
            'cotizacion' => $cotizacion,
            'cliente' => $cotizacion->cliente,
            'motor' => $cotizacion->motor,
            'firmante' => $this->firmanteCotizacion($cotizacion),
            'usarPortada' => true,


        ];
    }

    private function nombreArchivoCotizacionPdf(Cotizacion $cotizacion): string
    {
        $numero = trim((string) $cotizacion->numero);

        $cliente = optional($cotizacion->cliente)->cliente
            ? trim((string) $cotizacion->cliente->cliente)
            : 'CLIENTE';

        $subtitulo = $cotizacion->subtitulo
            ? trim((string) $cotizacion->subtitulo)
            : '';

        /*
     * Nombre base:
     * COT26-0004-A-V10 CEMENTOS PROGRESO PLANTA SAN GABRIEL Rebobinado Motor 3.45 KW
     */
        $nombre = trim($numero . ' ' . mb_strtoupper($cliente) . ' ' . $subtitulo);

        /*
     * Limpieza para evitar caracteres inválidos en nombres de archivo.
     */
        $nombre = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $nombre);

        /*
     * Limpia saltos de línea, tabs y espacios dobles.
     */
        $nombre = preg_replace('/\s+/', ' ', $nombre);

        /*
     * Opcional: quitar acentos/caracteres raros.
     * Si prefieres conservar acentos, comenta esta línea.
     */
        $nombre = Str::ascii($nombre);

        /*
     * Evitar nombres demasiado largos.
     */
        $nombre = Str::limit($nombre, 160, '');

        return trim($nombre) . '.pdf';
    }
    private function pathsPdfsAdjuntosCotizacion(Cotizacion $cotizacion, string $seccion): array
    {
        $relacion = $seccion === 'antes_items'
            ? $cotizacion->pdfsAntesItems
            : $cotizacion->pdfsDespuesItems;

        $paths = [];

        foreach ($relacion as $pdf) {
            if (!$pdf->path) {
                continue;
            }

            $relativePath = ltrim($pdf->path, '/');

            if (!Storage::disk('public')->exists($relativePath)) {
                continue;
            }

            $fullPath = storage_path('app/public/' . $relativePath);

            if (file_exists($fullPath)) {
                $paths[] = $fullPath;
            }
        }

        return $paths;
    }

    private function unirPdfs(array $paths, string $outputPath): void
    {
        $pdfFinal = new Fpdi();

        foreach ($paths as $path) {
            if (!$path || !file_exists($path)) {
                continue;
            }

            $pageCount = $pdfFinal->setSourceFile($path);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdfFinal->importPage($pageNo);
                $size = $pdfFinal->getTemplateSize($templateId);

                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';

                $pdfFinal->AddPage($orientation, [$size['width'], $size['height']]);
                $pdfFinal->useTemplate(
                    $templateId,
                    0,
                    0,
                    $size['width'],
                    $size['height'],
                    true
                );
            }
        }

        $pdfFinal->Output($outputPath, 'F');
    }
    private function firmanteCotizacion(Cotizacion $cotizacion): array
    {
        /*
     * Sam firma únicamente cuando la cotización fue creada por user id = 1.
     * Cualquier otro usuario firma como Irma.
     */
        if ((int) $cotizacion->creado_por === 1) {
            return $this->firmaSam();
        }

        return $this->firmaIrma();
    }

    private function firmaSam(): array
    {
        return [
            'nombre' => 'Ing. Samuel Mayorga, MAE, MBA',
            'cargo' => 'Gerente de Producción',
            'email' => 'samuel.mayorga@cmeamir.com',
            'celular' => '(502) 5207-6235',
            'oficina' => '(502) 2331-1596',
            'fax' => '(502) 2335-6638',
            'web' => null,
            'direccion_linea_1' => '23 ave 28-46 Zona 5 Guatemala,',
            'direccion_linea_2' => 'Guatemala C.A',
        ];
    }

    private function firmaIrma(): array
    {
        return [
            'nombre' => 'Lic. Irma de Mayorga',
            'cargo' => 'Gerente Administrativa',
            'email' => 'irma.mayorga@cmeamir.com',
            'celular' => '+502 5901-6592',
            'oficina' => '+502 2331-1596',
            'fax' => null,
            'web' => 'www.cmeamir.com',
            'direccion_linea_1' => '23 ave 28-46 Zona 5 Guatemala,',
            'direccion_linea_2' => 'Guatemala C.A',
        ];
    }
}
