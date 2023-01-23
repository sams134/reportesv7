<?php

namespace App\Http\Livewire\Customers;

use App\Models\Cliente;
use App\Models\Info_cliente;
use Livewire\Component;
use App\Models\Contacto;

class EditCustomer extends Component
{
   
    public $cant_contactos;
    public $cliente,$razon_social,$nit,$direccion_fiscal,$direccion_planta,$pais="Guatemala",$ciudad="Guatemala",$comentarios;
    public $contactos;
    public $id_cliente;
    public function mount(Cliente $c)
    {
        
        $this->cliente = $c->cliente;
        $this->razon_social = $c->info_cliente->razon_social;
        $this->nit = $c->info_cliente->nit;
        $this->direccion_fiscal = $c->info_cliente->direccion_fiscal;
        $this->direccion_planta = $c->info_cliente->direccion_planta;
        $this->pais = $c->pais;
        $this->ciudad = $c->ciudad;
        $this->comentarios = $c->info_cliente->comentarios;
        $this->id_cliente = $c->id_cliente;
        $this->contactos = collect();
        foreach($c->contactos as $contacto)
         {
            $this->contactos->push([
                'name' => $contacto->contacto,
                'telefono' => $contacto->telefono,
                'puesto' => $contacto->puesto,
                'email' => $contacto->email,
                'id' => $contacto->id
            ]);
            $this->cant_contactos = $this->cant_contactos + 1;
         }  
    }
    public function setCF(){
        $this->nit = "C/F";
    }
    public function setName(){
        $this->razon_social = $this->cliente;
    }
    public function setNameSA(){
        $this->razon_social = $this->cliente." S.A.";
    }
    public function setCiudad(){
        $this->direccion_fiscal = "Ciudad";
    }
    public function setPlantAddr(){
        $this->direccion_planta = $this->direccion_fiscal;
    }
    public function addContact()
    {
        $this->contactos->push([
            'name' => '',
            'telefono' => '',
            'puesto' => '',
            'email' => '',
            'id' => ''
        ]);
        $this->cant_contactos = $this->cant_contactos + 1;
    }
    public function deleteContact($key)
    {
        $this->contactos->pull($key);
        $this->cant_contactos--;
    }
    public function render()
    {
        
        return view('livewire.customers.edit-customer');
    }
    public function updateCustomer()
    {
        
        $cliente = Cliente::find($this->id_cliente);
        $cliente->update([
            'cliente' => $this->cliente,
            'ciudad' => $this->ciudad,
            'pais' => $this->pais
        ]);
        $cliente->info_cliente->update([
            'nit' => $this->nit,
            'razon_social' => $this->razon_social,
            'direccion_planta' => $this->direccion_planta,
            'direccion_fiscal' => $this->direccion_fiscal,
            'comentarios' => $this->comentarios
        ]);
        foreach ($this->contactos as $key=>$contact)
        {
            
        }
        return redirect()->route('clientes.index')->with('success','El cliente '.$cliente->cliente. ' fue editado exitosamente.');
    }
}
