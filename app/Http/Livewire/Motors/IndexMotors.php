<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use Livewire\Component;
use Livewire\WithPagination;

class IndexMotors extends Component
{
    use withPagination;
    public function render()
    {
        $motores = Motor::with([
            'cliente',              // Relación con clientes
            'tecnicos',         // Relación con asignaciones
            'trabajos',             // Relación con trabajos
            'bitacoras',            // Relación con bitácoras
            'fotos.tipoFoto',       // Relación con fotos y sus tipos
        ])
        ->where('year', 'like', '2M%') // Agregar el filtro
        ->orderBy('year', 'desc')
        ->orderBy('os', 'desc')
        ->paginate(100);
    
        
       //   return view('livewire.motors.index',compact('motores'));
        return view('livewire.motors.index-motors',compact('motores'))->with(["Carbon" => 'Carbon\Carbon']);
    }
}
