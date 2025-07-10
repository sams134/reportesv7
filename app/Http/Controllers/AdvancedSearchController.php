<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class AdvancedSearchController extends Controller
{
    //
    public $sort = 'fullos', $direction = 'desc';
     public $boards,$photo;
     protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => 'fullos'],
        'direction' => ['except' => 'desc'],
    ];
    public function __invoke(Request $request)
    {
        // Tomamos sólo el campo de marca (o cualquiera que quieras pasar)
       
        $marca = $request->input('marca');
        $modelo = $request->input('modelo');
        $serie = $request->input('serie');
         $user = auth()->user();
        $this->boards = $user->boards;
      
         $motores = Motor::with([
            'cliente',         // Relación con clientes
            'tecnicos',        // Relación con técnicos
            'trabajos',        // Relación con trabajos
            'bitacoras',       // Relación con bitácoras
            'fotos.tipoFoto',  // Relación con fotos y sus tipos
        ]);
         $motores = $motores->where('year', 'like', '2M%');
          if ($this->sort === "fullos") {
                $motores = $motores->orderBy('year', $this->direction)
                    ->orderBy('os', $this->direction)
                    ->paginate(100);
            } elseif ($this->sort === 'hp') {
                $motores = $motores->orderByRaw("CAST(hp AS UNSIGNED) {$this->direction}")
                    ->paginate(100);
            } elseif ($this->sort === 'rpm') {
                $motores = $motores->orderByRaw("CAST(rpm AS UNSIGNED) {$this->direction}")
                    ->paginate(100);
            } else {
                $motores = $motores->orderBy($this->sort, $this->direction)
                    ->paginate(100);
            }
         return view('livewire.motors.index-motors', [
            'motores' => $motores->withQueryString()
        ]);
        
    }
}
