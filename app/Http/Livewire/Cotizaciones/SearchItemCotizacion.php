<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\CotizacionCatalogoItem;
use Livewire\Component;
use App\Models\CotizacionItem;

class SearchItemCotizacion extends Component
{
    public $search = '';
    public $modoBusqueda = false;
    public $isOpen = false;

    public $crearItem = null;
    public $itemsRapidos = [];
    public $resultados = [];

    public function render()
    {
        $this->crearItem = CotizacionCatalogoItem::where('activo', 1)
            ->where('es_accion', 1)
            ->orderBy('orden')
            ->first();

        if (trim($this->search) === '') {
            $this->itemsRapidos = CotizacionCatalogoItem::rapidos()
                ->get();

            $this->resultados = [];
        } else {
            $this->itemsRapidos = [];

            $this->resultados = $this->buscarItemsHistoricos($this->search);
        }

        return view('livewire.cotizaciones.search-item-cotizacion');
    }

    public function abrirBuscador()
    {
        $this->modoBusqueda = true;
        $this->isOpen = true;
        $this->search = '';

        $this->dispatchBrowserEvent('abrir-buscador-items-cotizacion');
    }

    public function updatedSearch()
    {
        $this->isOpen = true;
    }

    public function seleccionarItem($id)
    {
        $item = CotizacionCatalogoItem::find($id);

        if (!$item) {
            return;
        }

        $this->emitUp('catalogoItemCotizacionSeleccionado', [
            'id' => $item->id,
        ]);

        $this->resetBuscador();
    }
    public function seleccionarItemHistorico($id)
    {
        $item = CotizacionItem::find($id);

        if (!$item) {
            return;
        }

        $this->emitUp('historialItemCotizacionSeleccionado', [
            'id' => $item->id,
        ]);

        $this->resetBuscador();
    }

    private function resetBuscador()
    {
        $this->search = '';
        $this->modoBusqueda = false;
        $this->isOpen = false;
        $this->itemsRapidos = [];
        $this->resultados = [];

        $this->dispatchBrowserEvent('cerrar-buscador-items-cotizacion');
    }
    public function cerrarBuscador()
    {
        if (!$this->modoBusqueda) {
            return;
        }

        $this->resetBuscador();
    }
    private function buscarItemsHistoricos($search)
    {
        $search = trim((string) $search);

        if ($search === '') {
            return collect();
        }

        /*
     * Buscamos IDs de los últimos items usados,
     * agrupados por nombre para no mostrar repetidos.
     *
     * Ejemplo:
     * Retenedor 20x43x12 Q45
     * Retenedor 20x43x12 Q50
     *
     * Solo devolverá el más reciente: Q50.
     */
        $ids = CotizacionItem::query()
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('descripcion', 'like', '%' . $search . '%');
            })

            /*
         * No queremos sugerir descuentos como items normales.
         */
            ->where(function ($query) {
                $query->whereNull('tipo_item')
                    ->orWhere('tipo_item', '!=', 'descuento');
            })

            /*
         * Agrupamos los items que tengan el mismo nombre.
         */
            ->selectRaw('MAX(id) AS id')
            ->groupBy('nombre')

            /*
         * Primero los que empiezan exactamente con lo escrito.
         *
         * "rete" prioriza:
         * Retenedor 20x43x12
         *
         * sobre:
         * Cambio de retenedor
         */
            ->orderByRaw(
                'CASE WHEN nombre LIKE ? THEN 0 ELSE 1 END',
                [$search . '%']
            )

            /*
         * Después priorizamos los usados recientemente.
         */
            ->orderByRaw('MAX(id) DESC')

            /*
         * Máximo solicitado.
         */
            ->limit(10)
            ->pluck('id');

        if ($ids->isEmpty()) {
            return collect();
        }

        /*
     * Obtenemos los modelos completos.
     */
        $items = CotizacionItem::whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        /*
     * Conservamos el orden calculado arriba.
     */
        return collect($ids)
            ->map(function ($id) use ($items) {
                return $items->get($id);
            })
            ->filter()
            ->values();
    }
}
