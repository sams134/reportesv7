<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use Livewire\Component;

class PruebasIndex extends Component
{
    public $motor;
    public function mount(Motor $motor){
        
        $this->motor = $motor;
    }
    public function render()
    {
        return view('livewire.pruebas.pruebas-index');
    }
}
