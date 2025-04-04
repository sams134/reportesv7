<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use Livewire\Component;

class ChangeStatusBatch extends Component
{
    public $motors; // Almacena el motor seleccionado
    public $motorIds, $statuses, $newStatus; // Almacena los ids de los motores seleccionados


    protected $listeners = ['openStatusModal'];
    public function openStatusModal($motorIds)
    {
        
        $this->motorIds = $motorIds;
        $this->motors = Motor::whereIn('id_motor', $motorIds)->get();
        
        $this->emit('show-modal-status-batch');
    }
    public function save()
    {
       
            $this->validate([
                'newStatus' => 'required',
            ]);
          
             Motor::whereIn('id_motor', $this->motorIds)->update(['status_id' => $this->newStatus]);
            $this->emit('status-changed',count($this->motorIds));  
            $this->emit('hide-modal-status-batch');
            $this->newStatus = null;
    }
    public function render()
    {
        $this->statuses = Status::all();
        return view('livewire.motors.change-status-batch');
    }
}
