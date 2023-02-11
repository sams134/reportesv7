<?php

namespace App\Http\Livewire\Customers;

use App\Models\Cliente;
use App\Models\Info_cliente;
use Livewire\Component;
use App\Models\Contacto;

class EditCustomer extends Component
{
    public $listeners = ['deleteContact'];
    public $cant_contactos;
    public $cliente,$razon_social,$nit,$direccion_fiscal,$direccion_planta,$pais="Guatemala",$ciudad="Guatemala",$comentarios;
    public $contactos,$contactosToDelete;
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
        $this->contactosToDelete = collect();
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
        if ($this->contactos[$key]["id"] != "")
         $this->contactosToDelete->push($this->contactos[$key]["id"]);
        
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
            if ($contact["id"] != "")
            {
                $contactoObj = Contacto::find($contact["id"]);
                $contactoObj->update([
                    'contacto' => $contact["name"],
                    'telefono' => $contact["telefono"],
                    'puesto' => $contact["puesto"],
                    'email' => $contact["email"],  
                ]);
             }else
             {
                 $contactoObj = Contacto::create([
                    'contacto' => $contact["name"],
                    'telefono' => $contact["telefono"],
                    'puesto' => $contact["puesto"],
                    'email' => $contact["email"],  
                    'id_cliente' => $cliente->id_cliente
                 ]);
             }
        }
        foreach ($this->contactosToDelete as $key=>$contact)
        {
            $contactoObj = Contacto::find($contact);
            $contactoObj->delete();
        }
        return redirect()->route('clientes.index')->with('success','El cliente '.$cliente->cliente. ' fue editado exitosamente.');
    }
    public function updateContactNumber()
    {
        $this->cant_contactos = $this->cant_contactos * 1;
        
        if ($this->contactos->count() != $this->cant_contactos)
        {
            if ($this->contactos->count() < $this->cant_contactos)
              for ($i=$this->contactos->count();$i<$this->cant_contactos;$i++)
                    $this->contactos->push([
                        'name' => '',
                        'telefono' => '',
                        'puesto' => '',
                        'email' => '',
                        'id' => '',
                    ]);
            else
            {
                $this->contactos->take($this->cant_contactos-$this->contactos->count())
                
                ->each(function ($contactoToDelete) { 
                    if ($contactoToDelete["id"] != "")
                        $this->contactosToDelete->push($contactoToDelete["id"]);
                });
                $this->contactos =  $this->contactos->take($this->cant_contactos);
            }
            
        }

    }
}
