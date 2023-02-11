<?php

namespace App\Http\Livewire\Customers;

use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Info_cliente;
use Livewire\Component;
use Illuminate\Support\Collection;




class CreateCustomers extends Component
{
    public $cant_contactos;
    public $cliente,$razon_social,$nit,$direccion_fiscal,$direccion_planta,$pais="Guatemala",$ciudad="Guatemala",$comentarios;
    public $contactos;

    public $listeners = ['deleteContact'];
   
    protected $rules = [
        'cliente' => 'required',
        'razon_social' => 'required',
        'nit' => 'required',
        'direccion_fiscal' => 'required',
        'contactos.*.name' => 'required',
        'contactos.*.telefono' => '',
        'contactos.*.puesto' => '',
        'contactos.*.email' => '',
    ];

    public function mount()
    {
     $this->contactos = collect();  
    }
    public function render()
    {
        return view('livewire.customers.create-customers');
    }

    public function saveCustomer()
    {
        $this->emit('nonComplete');
        $this->validate();
         
       
        $cliente = Cliente::create([
            'cliente' => $this->cliente,
            'pais' => $this->pais,
            'ciudad' => $this->ciudad,
        ]);
        $info_cliente = Info_cliente::create([
            'nit' => $this->nit,
            'direccion_fiscal' => $this->direccion_fiscal,
            'razon_social' => $this->razon_social,
            'direccion_planta' => $this->direccion_planta,
            'comentarios' => $this->comentarios,
            'id_cliente' => $cliente->id_cliente,
        ]);
       foreach ($this->contactos as $contacto)
       {
           
           $contacto = Contacto::create([
               'contacto' => $contacto['name'],
               'telefono' => $contacto['telefono'],
               'puesto' => $contacto['puesto'],
               'email' => $contacto['email'],
               'id_cliente' => $cliente->id_cliente
           ]);
           
       }
        
        return redirect()->route('clientes.index')->with('success','El cliente '.$cliente->cliente. ' fue guardado exitosamente.');
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
            'email' => ''
        ]);
        $this->cant_contactos = $this->cant_contactos + 1;
    }
    public function deleteContact($key)
    {
        $this->contactos->pull($key);
        $this->cant_contactos--;
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
                        'email' => ''
                    ]);
            else
                $this->contactos =  $this->contactos->take($this->cant_contactos);
            
        }

    }
}
