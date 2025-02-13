<?php

namespace App\Http\Livewire\Search;

use App\Models\Motor;
use App\Models\MotorMetalizado;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Searchbox extends Component
{
    public $search = '';
    public $motores = [];
    public $metalizados = [];
    public function mount()
    {
        $this->motores = [];
    }
    public function render()
    {

        if (!empty($this->search)) {
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

            // Procesar la búsqueda si existe
            $search = $this->search;
            if ($search) {
                // Si la búsqueda contiene un guion (ej. "2M23-056")
                if (strpos($search, '-') !== false) {
                    $parts = explode('-', $search, 2);
                    if (count($parts) == 2) {
                        $yearSearch = trim($parts[0]); // Por ejemplo "2M23"
                        $osSearch = trim($parts[1]);   // Por ejemplo "56"
                        // Asegurarse de que OS tenga 4 dígitos
                        $osSearch = str_pad($osSearch, 4, '0', STR_PAD_LEFT);
                        $motores = $motores->where('year', 'like', "%$yearSearch")
                            ->where('os', 'like', "$osSearch%");
                    }
                }
                // Si empieza con un número (buscar por OS)
                elseif (is_numeric($search[0])) {
                    $os = str_pad($search, 4, '0', STR_PAD_LEFT);
                    $motores = $motores->where('os', 'like', "$os%");
                }
                // Si empieza con una letra (buscar en cliente, contacto o técnico)
                elseif (ctype_alpha($search[0])) {
                    $motores = $motores->where(function ($query) use ($search) {
                        $query->whereHas('cliente', function ($query) use ($search) {
                            $query->where('cliente', 'like', "%$search%");
                        })
                            ->orWhereHas('cliente.contactos', function ($query) use ($search) {
                                $query->where('contacto', 'like', "%$search%");
                            })
                            ->orWhereHas('tecnicos', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                    });
                }
            }
            $this->motores = $motores->orderBy('year', 'desc')
                ->orderBy('os', 'desc')
                ->limit(31)
                ->get();

            // buscar ahora los metalizados

            $motores = MotorMetalizado::with([
                'cliente',         // Relación con clientes
                'motor',           // Relación con motores
                'images',          // Relación con imágenes
            ]);
            $motores = $motores->where('year', 'like', 'MET%');
            if ($search) {
                // Si la búsqueda contiene un guion (ej. "2M23-056")
                if (strpos($search, '-') !== false) {
                    $parts = explode('-', $search, 2);
                    if (count($parts) == 2) {
                        $yearSearch = trim($parts[0]); // Por ejemplo "2M23"
                        $osSearch = trim($parts[1]);   // Por ejemplo "56"
                        // Asegurarse de que OS tenga 4 dígitos
                        $osSearch = str_pad($osSearch, 4, '0', STR_PAD_LEFT);
                        $motores = $motores->where('year', 'like', "%$yearSearch")
                            ->where('os', 'like', "$osSearch%");
                    }
                }
                // Si empieza con un número (buscar por OS)
                elseif (is_numeric($search[0])) {
                    $os = str_pad($search, 4, '0', STR_PAD_LEFT);
                    $motores = $motores->where('os', 'like', "$os%");
                }
                // Si empieza con una letra (buscar en cliente, contacto o técnico)
                elseif (ctype_alpha($search[0])) {
                    $motores = $motores->where(function ($query) use ($search) {
                        $query->whereHas('cliente', function ($query) use ($search) {
                            $query->where('cliente', 'like', "%$search%");
                        })
                            ->orWhereHas('cliente.contactos', function ($query) use ($search) {
                                $query->where('contacto', 'like', "%$search%");
                            })
                            ->orWhereHas('tecnicos', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                    });
                }
            }
            $this->metalizados = $motores->orderBy('year', 'desc')
                ->orderBy('os', 'desc')
                ->limit(31)
                ->get();
        }

        return view('livewire.search.searchbox');
    }
}
