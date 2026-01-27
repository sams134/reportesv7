<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\Cliente;
use Livewire\Component;


class NuevaCotizacion extends Component
{
    public $clientes;

    

    public function render()
    {
        $clientes = Cliente::orderBy('cliente', 'asc')->get();
        $this->clientes = $clientes;

        return view('livewire.cotizaciones.nueva-cotizacion');
    }
}
