<?php

namespace App\Http\Livewire\Metalizados;

use App\Models\Motor;
use App\Models\MotorMetalizado;
use Livewire\Component;

class MetalizadosIndex extends Component
{
    
    public $search = '';
    public $sort = 'id_motor', $direction = 'desc';
    protected $listeners = [
        'closeNewMetalizado' => 'render',
    ];
   /*  public function render()
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
        $motores = $motores->where('year', 'like', 'MET%');

        if ($this->sort === "fullos") {
            $motores = $motores
                ->orderBy('year', $this->direction)
                ->orderBy('os', $this->direction)
                ->paginate(100);
        } 
        else {
            $motores = $motores
                ->orderBy($this->sort, $this->direction)
                ->paginate(100);
        }
 
        return view('livewire.metalizados.metalizados-index',compact('motores'));
    } */


    public function render()
    {
        $user = auth()->user();
        $metalizados = MotorMetalizado::with([
            'cliente',
            'motor'
        ]);
        $metalizados = $metalizados->where('year', 'like', 'MET%');
        $metalizados = $metalizados->orderBy('year', 'desc')->orderBy('os', 'desc')->paginate(100);
       
        return view('livewire.metalizados.metalizados-index')->with('metalizados', $metalizados);
    }
}
