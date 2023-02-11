<?php

namespace App\Http\Livewire\Customers;

use App\Models\Contacto;
use Livewire\Component;

class EditContact extends Component
{
    
    public Contacto $contacto;

    protected $rules = [
        'contacto.contacto' => '',
        'contacto.telefono' => '',
        'contacto.puesto' => '',
        'contacto.email' => '',
    ];
    public function mount(Contacto $contacto){
        $this->contacto = $this->contacto;
    }
    public function render()
    {
        return view('livewire.customers.edit-contact');
    }
    public function save()
    {
        $this->contacto->save();
        $this->emit('closeEditedContact',$this->contacto->id);
        $this->emitTo('customers.show-customers','render');
        $this->emit('alert',"El contacto fue actualizado");
    }
}
