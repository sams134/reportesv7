<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\CotizacionCatalogoItem;
use Livewire\Component;

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

            $this->resultados = CotizacionCatalogoItem::buscando(trim($this->search))
                ->limit(10)
                ->get();
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
}
