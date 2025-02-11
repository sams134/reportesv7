<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use Livewire\Component;

class ShowPedido extends Component
{
    public $motor;
    protected $listeners = ['materialAdded'];
    public function mount(Motor $motor)
    {
        
        $this->motor = $motor;
    }
    public function render()
    {
        $this->motor = Motor::find($this->motor->id_motor);
        
        return view('livewire.motors.show-pedido');
    }
    public function materialAdded()
    {
        $this->motor = Motor::find($this->motor->id_motor);
        $this->render();
    }
}
