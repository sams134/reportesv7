<?php

namespace App\Http\Livewire\Customers;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCustomers extends Component
{
    use WithPagination;
    public $search="";
    public function render()
    {
        $search = $this->search;
        $customers = Cliente::where('cliente','like','%'.$this->search.'%')
                    ->orWhereHas('info_cliente',function ($q) use ($search){
                        $q->where('razon_social', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('contactos',function ($q) use ($search){
                        $q->where('contacto', 'like', '%' . $search . '%');
                    })
                    ->orderBy('cliente','asc')->paginate(20);
        return view('livewire.customers.index-customers',compact('customers'));
    }
}
