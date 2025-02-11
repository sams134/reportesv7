<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use Livewire\Component;

class PedidoMateriales extends Component
{
    public $cant,$items;
    public $material,$presentacion;
    public $motor;
    public $materiales;

    public function mount(Motor $motor)
    {
       $this->motor = $motor;
    }
    public function render()
    {
        $materiales = $this->motor->materialesPedidos;
        return view('livewire.motors.pedido-materiales');
    }
    public function addMaterial()
    {
        try {
            $this->validate([
                'material' => 'required',
                'presentacion' => '',
                'cant' => 'required|numeric',
            ]);
            $this->motor->materialesPedidos()->create([
                'material' => $this->material,
                'presentacion' => $this->presentacion,
                'cantidad' => (float)$this->cant,
                'id_material' => 0,
                'id_user' => auth()->id(),
            ]);
            $this->reset(['material','presentacion','cant']);
            $this->emit('materialAdded');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
       
    }
}
