<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\Cotizacion;
use Livewire\Component;

class PreviewCotizacion extends Component
{
    public $cotizacion;
    public $tituloCotizacion = '';
    public $subtituloCotizacion = '';

    public $pdfUsarPortada = false;
    public $pdfUsarCartaPresentacion = true;
    public $pdfMostrarDesgloseIva = true;

    public function mount(Cotizacion $cotizacion)
    {
        /*
         * Cargamos desde ahora las mismas relaciones principales
         * que posteriormente necesitaremos para el preview completo.
         */
        $cotizacion->load([
            'cliente.info_cliente',
            'motor.infoMotor',
            'motor.fotos',
            'contactosCotizacion',
            'itemsCotizacion',
            'creadoPor',

            'unificadaDetalles.items',
            'unificadaDetalles.cotizacionOrigen.motor.infoMotor',

            'excelGrupos.items',

            'pdfsAntesItems',
            'pdfsDespuesItems',
        ]);

        $this->cotizacion = $cotizacion;
        $this->tituloCotizacion = $cotizacion->titulo ?? '';
        $this->subtituloCotizacion = $cotizacion->subtitulo ?? '';

        $this->pdfUsarPortada = false;
        $this->pdfUsarCartaPresentacion = true;
        $this->pdfMostrarDesgloseIva = true;
    }
    public function abrirModalOpcionesPdf()
    {
        $this->pdfUsarPortada = false;
        $this->pdfUsarCartaPresentacion = true;
        $this->pdfMostrarDesgloseIva = true;

        $this->dispatchBrowserEvent('abrir-modal-opciones-pdf-cotizacion');
    }
    public function generarPdfDesdeModal(
        $usarPortada = false,
        $usarCartaPresentacion = true,
        $mostrarDesgloseIva = true
    ) {
        $this->pdfUsarPortada = (bool) $usarPortada;
        $this->pdfUsarCartaPresentacion = (bool) $usarCartaPresentacion;
        $this->pdfMostrarDesgloseIva = (bool) $mostrarDesgloseIva;

        $urlPdf = route('admin.cotizaciones.downloadPdf', [
            'cotizacion' => $this->cotizacion->id,
            'portada' => $this->pdfUsarPortada ? 1 : 0,
            'carta' => $this->pdfUsarCartaPresentacion ? 1 : 0,
            'iva' => $this->pdfMostrarDesgloseIva ? 1 : 0,
        ]);

        $this->dispatchBrowserEvent('cotizacion-pdf-listo', [
            'url' => $urlPdf,
        ]);
    }

    public function render()
    {
        return view('livewire.cotizaciones.preview-cotizacion');
    }
}
