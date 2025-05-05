<?php

namespace App\Http\Livewire\Pruebas;

use Livewire\Component;

class AjustesTabla extends Component
{
    public $ajustes, $comparedToReal = false;
    public $initial_final, $carga_opuesto, $allowed_final;
    public $medida_max, $medida_min;
    protected $listeners = ['updateMedidas' => 'updateMedidas'];
    public function mount($ajustes, $initial_final, $carga_opuesto, $allowed_final)
    {
        $this->initial_final = $initial_final;
        $this->carga_opuesto = $carga_opuesto;
        $this->allowed_final = $allowed_final;
        $this->ajustes = $ajustes;
        if ($ajustes[$initial_final][$carga_opuesto]['ax']) {
            if ($allowed_final && $ajustes[1][$carga_opuesto]['rod']['p'])
                $this->comparedToReal = true;
            $this->medida_max =
                $allowed_final && $ajustes[1][$carga_opuesto]['rod']['p']
                ? max(
                    $ajustes[1][$carga_opuesto]['rod']['p'],
                    $ajustes[1][$carga_opuesto]['rod']['q'],
                    $ajustes[1][$carga_opuesto]['rod']['r'],
                )
                : $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['diametro_externo'];
            $this->medida_min =
                $allowed_final && $ajustes[1][$carga_opuesto]['rod']['p']
                ? min(
                    $ajustes[1][$carga_opuesto]['rod']['p'],
                    $ajustes[1][$carga_opuesto]['rod']['q'],
                    $ajustes[1][$carga_opuesto]['rod']['r'],
                )
                : $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['diametro_externo'];
        }
    }
    public function updateMedidas($ajustes,$initial_final, $carga_opuesto, $allowed_final)
    {
        if ($this->initial_final == $initial_final && $this->carga_opuesto == $carga_opuesto && $this->allowed_final == $allowed_final) {
        $this->ajustes = $ajustes;
        if ($ajustes[$initial_final][$carga_opuesto]['ax']) {
            if ($allowed_final && $ajustes[1][$carga_opuesto]['rod']['p'])
                $this->comparedToReal = true;
            $this->medida_max =
                $allowed_final && $ajustes[1][$carga_opuesto]['rod']['p']
                ? max(
                    $ajustes[1][$carga_opuesto]['rod']['p'],
                    $ajustes[1][$carga_opuesto]['rod']['q'],
                    $ajustes[1][$carga_opuesto]['rod']['r'],
                )
                : $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['diametro_externo'];
            $this->medida_min =
                $allowed_final && $ajustes[1][$carga_opuesto]['rod']['p']
                ? min(
                    $ajustes[1][$carga_opuesto]['rod']['p'],
                    $ajustes[1][$carga_opuesto]['rod']['q'],
                    $ajustes[1][$carga_opuesto]['rod']['r'],
                )
                : $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['diametro_externo'];
        }
      
        }
    }
    public function render()
    {
        return view('livewire.pruebas.ajustes-tabla');
    }
}
