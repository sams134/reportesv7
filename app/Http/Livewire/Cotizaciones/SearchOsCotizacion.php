<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\Motor;
use Livewire\Component;

class SearchOsCotizacion extends Component
{
    public $cliente_id = null;

    public $search = '';

    public $motores = [];

    public $sugerencias = [];

    public $isOpen = false;

    public $selectedLabel = '';

    public $motorSeleccionadoId = null;
    public $clienteMotorSeleccionadoId = null;
    public $preservarSearchEnCambioCliente = false;

    /*
     * Ajusta estos IDs según tu tabla de statuses.
     * Aquí debes colocar los status_id que ya son facturados.
     */
    public $statusFacturadoIds = [13, 14, 15];

    protected $listeners = [
        'clienteCotizacionActualizado' => 'actualizarCliente',
    ];

    public function mount($cliente_id = null)
    {
        $this->cliente_id = $cliente_id;
        $this->cargarSugerencias();
    }

    public function render()
    {
        if (!empty($this->search)) {
            $this->buscarMotores();
        } else {
            $this->motores = [];
        }

        $this->cargarSugerencias();

        return view('livewire.cotizaciones.search-os-cotizacion');
    }

    public function actualizarCliente($cliente_id)
    {
        $this->cliente_id = $cliente_id;

        if (
            $this->preservarSearchEnCambioCliente &&
            (int) $this->clienteMotorSeleccionadoId === (int) $cliente_id
        ) {
            $this->preservarSearchEnCambioCliente = false;
            $this->isOpen = false;
            $this->motores = [];

            $this->cargarSugerencias();

            $this->dispatchBrowserEvent('cerrar-dropdown-os-cotizacion');

            return;
        }

        $this->search = '';
        $this->selectedLabel = '';
        $this->motorSeleccionadoId = null;
        $this->clienteMotorSeleccionadoId = null;
        $this->preservarSearchEnCambioCliente = false;

        $this->motores = [];
        $this->isOpen = false;

        $this->cargarSugerencias();

        $this->dispatchBrowserEvent('cerrar-dropdown-os-cotizacion');
    }

    public function updatedSearch()
    {
        $this->isOpen = true;
    }

    public function abrirDropdown()
    {
        $this->isOpen = true;
    }

    public function cerrarDropdown()
    {
        // Pequeño delay visual lo maneja mejor el mousedown en los items.
        $this->isOpen = false;
    }

    public function seleccionarOfertaPresupuestaria()
    {
        $this->selectedLabel = 'Equipo no ha ingresado a taller, Oferta presupuestaria';
        $this->search = $this->selectedLabel;

        $this->motorSeleccionadoId = null;
        $this->clienteMotorSeleccionadoId = null;
        $this->preservarSearchEnCambioCliente = false;

        $this->isOpen = false;
        $this->motores = [];

        $this->dispatchBrowserEvent('cerrar-dropdown-os-cotizacion');

        $this->emitUp('osCotizacionSeleccionada', [
            'tipo' => 'sin_ingreso',
            'motor_id' => null,
            'label' => $this->selectedLabel,
        ]);
    }

    public function seleccionarMotor($id_motor)
    {
        $motor = Motor::with('cliente')
            ->where('id_motor', $id_motor)
            ->first();

        if (!$motor) {
            return;
        }

        $label = $motor->fullos . ': ' . optional($motor->cliente)->cliente;

        $this->motorSeleccionadoId = $motor->id_motor;
        $this->clienteMotorSeleccionadoId = $motor->id_cliente;
        $this->preservarSearchEnCambioCliente = true;

        $this->selectedLabel = $label;
        $this->search = $label;
        $this->isOpen = false;
        $this->dispatchBrowserEvent('cerrar-dropdown-os-cotizacion');

        $this->emitUp('osCotizacionSeleccionada', [
            'tipo' => 'motor',
            'motor_id' => $motor->id_motor,
            'id_cliente' => $motor->id_cliente,
            'fullos' => $motor->fullos,
            'label' => $label,
            'cliente' => optional($motor->cliente)->cliente,
        ]);
    }

    public function seleccionarPrimeraCoincidencia()
    {
        $this->buscarMotores();

        if (count($this->motores) > 0) {
            $this->seleccionarMotor($this->motores[0]['id_motor']);
            return;
        }

        $this->seleccionarOfertaPresupuestaria();
    }

    private function cargarSugerencias()
    {
        if (!$this->cliente_id) {
            $this->sugerencias = [];
            return;
        }

        $query = Motor::with(['cliente', 'fotos'])
            ->where('id_cliente', $this->cliente_id)
            ->where('year', 'like', '2M%');

        if (!empty($this->statusFacturadoIds)) {
            $query->whereNotIn('status_id', $this->statusFacturadoIds);
        }

        $this->sugerencias = $query
            ->orderBy('year', 'desc')
            ->orderBy('os', 'desc')
            ->limit(3)
            ->get()
            ->toArray();
    }

    private function buscarMotores()
    {
        $search = trim($this->search);

        if ($search === '') {
            $this->motores = [];
            return;
        }

        $query = Motor::with(['cliente', 'fotos'])
            ->where('year', 'like', '2M%');

        if (strpos($search, '-') !== false) {
            $parts = explode('-', $search, 2);

            if (count($parts) === 2) {
                $yearSearch = trim($parts[0]);
                $osSearch = trim($parts[1]);
                $osSearch = str_pad($osSearch, 4, '0', STR_PAD_LEFT);

                $query->where('year', 'like', "%$yearSearch")
                    ->where('os', 'like', "$osSearch%");
            }
        } elseif (isset($search[0]) && is_numeric($search[0])) {
            $os = str_pad($search, 4, '0', STR_PAD_LEFT);

            $query->where('os', 'like', "$os%");
        } elseif (isset($search[0]) && ctype_alpha($search[0])) {
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('cliente', 'like', "%$search%");
            });
        }

        $this->motores = $query
            ->orderBy('year', 'desc')
            ->orderBy('os', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }
}
