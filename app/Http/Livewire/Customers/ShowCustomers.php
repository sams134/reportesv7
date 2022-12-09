<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class ShowCustomers extends Component
{
    public $customers;

    public function render()
    {
        $this->customers = $this->loadCustomers();
        return view('livewire.customers.show-customers');
    }
    public function loadCustomers()
    {
        $customers = Customer::all();
        return $customers;
    }
}
