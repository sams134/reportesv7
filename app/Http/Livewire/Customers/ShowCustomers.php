<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Contacto;

class ShowCustomers extends Component
{
    public Cliente $cliente;

    protected $listeners = ['render', 'deleteContact'];
    public function mount($cliente)
    {

        $this->cliente = $cliente;
    }
    public function render()
    {
        $this->cliente = Cliente::find($this->cliente->id_cliente);
        return view('livewire.customers.show-customers');
    }
    public function deleteContact($id)
    {
        Contacto::find($id)->delete();
        $this->render();
    }
   
}
