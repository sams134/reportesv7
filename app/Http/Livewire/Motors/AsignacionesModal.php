<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;

class AsignacionesModal extends Component
{
    public $motor; // Almacena el motor seleccionado
    public $tecnicos,$statuses;
    protected $listeners = ['openAsignacionesModal'];
    public $tecnicoSelected = [];

    // Este método se ejecuta cuando se emite el evento con el ID del motor
    public function openAsignacionesModal($motorId)
    {
        $this->motor = Motor::find($motorId);
        
        // Inicializar el arreglo de técnicos seleccionados
        $this->tecnicoSelected = [];
        if ($this->motor && $this->motor->tecnicos) {
            foreach ($this->motor->tecnicos as $tec) {
                // Marcamos como true para cada técnico asignado
                $this->tecnicoSelected[$tec->id] = true;
            }
        }
        
        $this->dispatchBrowserEvent('show-modal');
    }
    public function saveAsignaciones()
    {
        // Eliminar todas las asignaciones
        $this->motor->tecnicos()->detach();
        
        // Asignar los técnicos seleccionados
        foreach ($this->tecnicoSelected as $id => $selected) {
            if ($selected) {
                $this->motor->tecnicos()->attach($id, ['asignado_por' => auth()->user()->id]);
            }
        }
        // Verificar si hay al menos un técnico asignado
        if ($this->motor->tecnicos()->count() > 0) {
            // Verificar si el status_id es null o -1
            if (is_null($this->motor->status_id) || $this->motor->status_id == -1) {
            $this->motor->status_id = 1;
            $this->motor->save();
            }
        }
        $this->dispatchBrowserEvent('hide-modal');
        $this->emitTo('motors.index-motors', 'render');
        $this->emitTo('motors.show-motor', 'render');
    }
    public function render()
    {
        $this->statuses = Status::all();
        $this->tecnicos = User::where('userType', User::TECNICO)
        ->where('activo', 1)
        ->orderBy('name')
        ->get();
        return view('livewire.motors.asignaciones-modal');
    }
}
