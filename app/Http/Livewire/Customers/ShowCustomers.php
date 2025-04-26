<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Motor;
use App\Models\Status;
use Livewire\WithPagination;

class ShowCustomers extends Component
{
    use withPagination;
    protected $paginationTheme = 'bootstrap';
    public Cliente $cliente;
    public $sort = 'fullos', $direction = 'desc';
    public $equipo, $statuses, $newStatus;

    protected $listeners = ['render', 'deleteContact'];
    public function mount($cliente)
    {
        $this->cliente = $cliente;
        $this->statuses = Status::all();
        $this->equipo = new Motor();
    }
    public function render()
    {
        $this->cliente = Cliente::find($this->cliente->id_cliente);
        $motores = Motor::with([
            'cliente',         // Relación con clientes
            'tecnicos',        // Relación con técnicos
            'trabajos',        // Relación con trabajos
            'bitacoras',       // Relación con bitácoras
            'fotos.tipoFoto',  // Relación con fotos y sus tipos
        ]);
        $motores = $motores->where('id_cliente', $this->cliente->id_cliente);
        $motores = $motores->where('year', 'like', '2M%');
        if ($this->sort === "fullos") {
            $motores = $motores->orderBy('year', $this->direction)
                ->orderBy('os', $this->direction)
                ->paginate(100);
        } elseif ($this->sort === 'hp') {
            $motores = $motores->orderByRaw("CAST(hp AS UNSIGNED) {$this->direction}")
                ->paginate(100);
        } elseif ($this->sort === 'rpm') {
            $motores = $motores->orderByRaw("CAST(rpm AS UNSIGNED) {$this->direction}")
                ->paginate(100);
        } else {
            $motores = $motores->orderBy($this->sort, $this->direction)
                ->paginate(100);
        }
        return view('livewire.customers.show-customers',[
            'motores' => $motores->withQueryString()
        ]);
    }
    public function deleteContact($id)
    {
        Contacto::find($id)->delete();
        $this->render();
    }
    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }
    public function loadStatusModal($id_motor)
    {
        $this->equipo = Motor::find($id_motor);
        $this->newStatus = $this->equipo->status_id;
    }
    public function updateStatus()
    {
        $this->validate([
            'newStatus' => 'required|exists:statuses,id',
        ]);

        $this->equipo->status_id = $this->newStatus;
        $this->equipo->save();
    }
   
}
