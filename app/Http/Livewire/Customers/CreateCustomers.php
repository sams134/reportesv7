<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Industry;
use Livewire\WithFileUploads;

class CreateCustomers extends Component
{
    use WithFileUploads;
    
    public $customer_name,$customer_bill_to,$customer_nit,$customer_address;
    public $user_email,$user_password,$user_confirm;
    public $logo,$patente_comercio,$patente_sociedad,$rtu,$representante;
    public $patente; // eliminar
    public $page=0;
    public $ct_name;
    public $contact_cant = 1;

    protected $listeners = ['setCount'];
    
    public function render()
    {
        $industries = Industry::orderBy('name')->get();
        return view('livewire.customers.create-customers',compact('industries'));
    }
   
    public function addContact() { $this->contact_cant += 1;}
    public function next()
    { 
        $this->page += 1;
        $this->emit('next');
         
    }
    public function prev()
    {
        $this->page -= 1;
        $this->emit('prev');
    }

    public function setCount($count)
    {
        $this->page = $count;
      
    }
}
