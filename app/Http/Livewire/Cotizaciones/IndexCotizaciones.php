<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\User;
use Livewire\Component;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class IndexCotizaciones extends Component
{
    public $content = '';

    protected $rules = [
      'content' => 'required|min:10',
    ];
    public function mount()
    {
        $user = auth()->user();
        if (!in_array($user->userType, [User::DEVELOPER,User::GERENCIA,User::ADMINISTRACION,User::VENDEDORES ])) {
            return redirect()->route('dashboard');
        }
    }
    public function render()
    {
        return view('livewire.cotizaciones.index-cotizaciones');
    }
    public function showCotizacion()
    {
        $this->validate();

       
     
        return redirect()->route('admin.cotizaciones.downloadPdf', ['cotID' => 1, 'data' => $this->content]);
        //route('cotizaciones.show', $cotizacion);
    }
}
