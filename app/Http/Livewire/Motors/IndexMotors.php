<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndexMotors extends Component
{
    use withPagination;
    public $search;
    public $equipo, $statuses, $newStatus;
    public $sort = 'fullos', $direction = 'desc';

    protected $listeners = ['removeMotor'];
    public function mount($search = '')
    {
        $this->search = $search;
        $this->equipo = new Motor();
        $this->statuses = Status::all();
    }
    public function render()
    {
        $user = auth()->user();

        // Iniciar la consulta con relaciones
        $motores = Motor::with([
            'cliente',         // Relación con clientes
            'tecnicos',        // Relación con técnicos
            'trabajos',        // Relación con trabajos
            'bitacoras',       // Relación con bitácoras
            'fotos.tipoFoto',  // Relación con fotos y sus tipos
        ]);

        // Filtrar siempre por year que empiece con "2M"
        $motores = $motores->where('year', 'like', '2M%');

        // Si el usuario es técnico, filtrar por motores asignados al técnico
        if ($user->userType === User::TECNICO) {
            $motores = $motores->whereHas('tecnicos', function ($query) use ($user) {
                $query->where('id_user', $user->id); // Solo motores asignados al técnico
            });
        }


        // Si hay una búsqueda
        $search = $this->search;
        if ($search) {
            // Si empieza con un número (buscar por OS)
            if (is_numeric($search[0])) {
                // Formatear el número a 4 dígitos con ceros a la izquierda
                $os = str_pad($search, 4, '0', STR_PAD_LEFT);

                // Filtrar por OS
                $motores = $motores->where('os', 'like', "$os%");
            }
            // Si empieza con una letra (buscar por cliente, contacto o técnico)
            else if (ctype_alpha($search[0])) {
                $motores = $motores->where(function ($query) use ($search) {
                    // Buscar coincidencias en el nombre del cliente
                    $query->whereHas('cliente', function ($query) use ($search) {
                        $query->where('cliente', 'like', "%$search%");
                    });

                    // O buscar coincidencias en el contacto asociado al cliente
                    $query->orWhereHas('cliente.contactos', function ($query) use ($search) {
                        $query->where('contacto', 'like', "%$search%");
                    });

                    // O buscar coincidencias en el nombre del técnico
                    $query->orWhereHas('tecnicos', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                });
            }
        }

        // Finalizar con orden y paginación
        if ($this->sort === "fullos") {
            $motores = $motores
                ->orderBy('year', $this->direction)
                ->orderBy('os', $this->direction)
                ->paginate(100);
        } elseif ($this->sort === 'hp') {
            $motores = $motores
                ->orderByRaw("CAST(hp AS UNSIGNED) {$this->direction}")
                ->paginate(100);
        } elseif ($this->sort === 'rpm') {
            $motores = $motores
                ->orderByRaw("CAST(rpm AS UNSIGNED) {$this->direction}")
                ->paginate(100);
        } else {
            $motores = $motores
                ->orderBy($this->sort, $this->direction)
                ->paginate(100);
        }



        //   return view('livewire.motors.index',compact('motores'));
        return view('livewire.motors.index-motors', compact('motores'))->with(["Carbon" => 'Carbon\Carbon']);
    }

    public function loadStatusModal(Motor $motor)
    {
        $this->equipo = $motor;
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
    public function removeMotor($id)
    {
        $motor = Motor::find($id);
        $motor->delete();
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
    public function updatedSearch()
    {
        // Reiniciar las propiedades de orden
        $this->sort = 'fullos';
        $this->direction = 'desc';
        $this->resetPage();
    }
}
