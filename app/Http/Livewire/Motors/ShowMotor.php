<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use Livewire\Component;

class ShowMotor extends Component
{
    public $motor;
    public $equipo,$statuses,$newStatus;

    public function mount(Motor $motor)
    {
        $this->motor = $motor;
        $this->equipo = $motor->equipo;
        $this->statuses = Status::all();
    }

    public function render()
    {
        return view('livewire.motors.show-motor')->with(["Carbon" => 'Carbon\Carbon']);
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

        $this->motor->status_id = $this->newStatus;
        $this->motor->save();
        
    }
}
