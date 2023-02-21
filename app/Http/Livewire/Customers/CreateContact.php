<?php

namespace App\Http\Livewire\Customers;

use App\Models\Contacto;
use Livewire\Component;

class CreateContact extends Component
{
    public $name,$telefono,$puesto,$email,$id_cliente;

    public function mount($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }
    public function render()
    {
        return view('livewire.customers.create-contact');
    }

    public function store()
    {
        $contacto = Contacto::create([
            'contacto' => $this->name,
            'telefono' => $this->telefono,
            'puesto' => $this->puesto,
            'email' => $this->email,
            'id_cliente' => $this->id_cliente
        ]); 
        $this->emit('render');
        $this->emit('closeNewContact');
    }
}
