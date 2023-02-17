<?php

namespace App\Http\Livewire\Customers;

use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Info_cliente;
use Livewire\Component;

class CreateCustomerModal extends Component
{
    public $cliente,$razon_social,$nit,$fiscal,$direccion_planta,$contacto,$telefono,$puesto,$email;
    protected $rules = [
        'cliente' => "required",

    ];

    public function render()
    {
        return view('livewire.customers.create-customer-modal');
    }

    public function updatedCliente(){
        if ($this->cliente == "")
           $this->razon_social = "";
        else
            $this->razon_social = $this->cliente." S.A.";
        $this->render();
    }
    public function updatedFiscal(){
       
            $this->direccion_planta = $this->fiscal;
        $this->render();
    }
    public function store(){
        $this->validate();
        $cliente = Cliente::create([
            'cliente' => $this->cliente,
            'pais' => 'Guatemala',
            'ciudad' => 'Guatemala'
        ]);
        Info_cliente::create([
            'nit' => $this->nit,
            'razon_social' => $this->razon_social,
            'direccion_planta' => $this->direccion_planta,
            'direccion_fiscal' => $this->fiscal,
            'id_cliente' => $cliente->id_cliente,
        ]);
        Contacto::create([
            'contacto' => $this->contacto,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'puesto' => $this->puesto,
            'id_cliente' => $cliente->id_cliente
        ]);
        $this->emit('newCustomerAdded',$cliente->id_cliente); // enviado a componente create new motor
        $this->emit('closeNewCustomer'); // enviado al JS de la pagina para cerrar el modal
    }
}
