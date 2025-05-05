<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use App\Models\OptionTornero;
use Livewire\Component;

class Shaft extends Component
{
    public $ajustes, $motor, $allowed_initial = true, $allowed_final = true;
    public $decisiones,$options;
    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
        $this->decisiones = OptionTornero::all();
        $requiredCombinations = [
            ['carga_opuesto' => 0, 'initial_final' => 0],
            ['carga_opuesto' => 1, 'initial_final' => 0],
        ];
        foreach ($requiredCombinations as $combination)
            if (!$this->motor->ajustes->where('carga_opuesto', $combination['carga_opuesto'])->where('initial_final', $combination['initial_final'])->first())
                $this->allowed_initial = false;
        if ($this->allowed_initial) {
            $requiredCombinations = [
                ['carga_opuesto' => 0, 'initial_final' => 1],
                ['carga_opuesto' => 1, 'initial_final' => 1],
            ];
            foreach ($requiredCombinations as $combination)
                if (!$this->motor->ajustes->where('carga_opuesto', $combination['carga_opuesto'])->where('initial_final', $combination['initial_final'])->first())
                    $this->allowed_final = false;
            //$this->ajustes[0][0]['bearing'] = $this->motor->ajustes->where('carga_opuesto', 0)->where('initial_final', 0)->first()->rodamiento;
        }
        //$this->ajustes['initial_final']['carga_opuesto']
        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 2; $j++) {
                $rod = $this->motor->ajustes->where('carga_opuesto', $j)->where('initial_final', $i)->first();
                $this->ajustes[$i][$j]['rod'] = $rod;
                $this->ajustes[$i][$j]['e1'] = $rod?$rod->e1:null;
                $this->ajustes[$i][$j]['e2'] = $rod?$rod->e2:null;
              
                if ($rod && $this->ajustes[$i][$j]['rod']->rodamiento->diametro_interno < 76) {
                  // dd($i,$j,$this->ajustes[$i][$j]['rod']->rodamiento->diametro_interno);
                    $this->ajustes[$i][$j]['e3'] = $rod?($rod->e1+$rod->e2)/2:null;
                    
                }else{
                    $this->ajustes[$i][$j]['e3'] = $rod?$rod->e3:null;
               
                }
                $this->ajustes[$i][$j]['designacion'] = $rod?$this->printDesignacion($rod):null;
                $this->options[$i][$j]['id'] = $rod?$rod->options_tornero_eje_id:null;
                $this->options[$i][$j]['decision'] = $rod?$rod->recomendacion_eje:null;
            }
        }
        

    }
    public function render()
    {
        return view('livewire.pruebas.shaft');
    }

    public function saveMedidas($i, $j)
    {
       
        try {
            if ($this->ajustes[$i][$j]['rod']['rodamiento']['diametro_interno'] > 76) {
                $this->validate([
                    'ajustes.' . $i . '.' . $j . '.e1' => 'required',
                    'ajustes.' . $i . '.' . $j . '.e2' => 'required',
                ]);
            }else{
                $this->validate([
                    'ajustes.' . $i . '.' . $j . '.e1' => 'required',
                    'ajustes.' . $i . '.' . $j . '.e2' => 'required',
                    'ajustes.' . $i . '.' . $j . '.e3' => 'required',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->mount($this->motor);
            throw $e;
        }
        $e1 = $this->ajustes[$i][$j]['e1'];
        $e2 = $this->ajustes[$i][$j]['e2'];
        $e3 = $this->ajustes[$i][$j]['e3'];
        $rod = $this->motor->ajustes->where('carga_opuesto', $j)->where('initial_final', $i)->first();
        $this->ajustes[$i][$j]['rod'] = $rod;
        $this->ajustes[$i][$j]['rod']->e1 = $e1;
        $this->ajustes[$i][$j]['rod']->e2 = $e2;
        
        if ($this->ajustes[$i][$j]['rod']['rodamiento']['diametro_interno'] < 76) {
            $this->ajustes[$i][$j]['rod']->e3 = ($e1+$e2) / 2;
        }else{
            $this->ajustes[$i][$j]['rod']->e3 = round((float)$e3, 4);
        }
        $this->ajustes[$i][$j]['rod']->options_tornero_eje_id = $this->options[$i][$j]['id'];
        $this->ajustes[$i][$j]['rod']->recomendacion_eje = $this->options[$i][$j]['decision'];
        $this->ajustes[$i][$j]['rod']->user_medida_eje_id = auth()->user()->id;
        
        $this->ajustes[$i][$j]['rod']->save();
        $this->mount($this->motor);
        $inicial_final = $i == 0 ? 'iniciales' : 'finales';
        $carga_opuesto = $j == 0 ? 'de carga ' : 'opuesto a la carga ';
        $this->emit('savedMedidas', "Se actualizaron las medidas $inicial_final del lado $carga_opuesto");
    }

    public function printDesignacion($motorAjuste)
    {

        $designacion = "";
        if ($motorAjuste['rodamientoMarca'])
            $designacion .= $motorAjuste['rodamientoMarca']['name'] . " ";
        if ($motorAjuste->rodamiento)
            $designacion .= $motorAjuste->rodamiento->designacion;
        switch ($motorAjuste->jaula) {
            case 1:
                if ($motorAjuste->rodamiento->tipo == 2)
                    $designacion = $designacion . " ECJ";
                break;
            case 2: //M
                if ($motorAjuste->rodamiento->tipo == 2)
                    $designacion = $designacion . " ECM";
                elseif ($motorAjuste->rodamiento->tipo == 1)
                    $designacion = $designacion . " /M";
                break;
            case 3: //p
                if ($motorAjuste->rodamiento->tipo == 2)
                    $designacion = $designacion . " ECP";
                break;
        }
        switch ($motorAjuste->sellos) {
            case 2: //2RS
                $designacion = $designacion . " 2RS";
                break;
            case 3: //ZZ
                $designacion = $designacion . " ZZ";
                break;
        }
        switch ($motorAjuste->juego_radial) {
            case 2: //C3
                $designacion = $designacion . " C3";
                break;
            case 3: //C4
                $designacion = $designacion . " C4";
                break;
        }
        switch ($motorAjuste->aislado) {
            case 2: //INSOCOAT
                $designacion = $designacion . " VL0241";
                break;
        }
        return $designacion;
    }
    public function copyMedidas($j)
    {
        $this->ajustes[1][$j]['e1'] = $this->ajustes[0][$j]['e1'];
        $this->ajustes[1][$j]['e2'] = $this->ajustes[0][$j]['e2'];
        if ($this->ajustes[0][$j]['rod']['rodamiento']['diametro_interno'] < 76) {
            $this->ajustes[1][$j]['e3'] = ($this->ajustes[0][$j]['e1'] + $this->ajustes[0][$j]['e2']) / 2;
        }else{
            $this->ajustes[1][$j]['e3'] = $this->ajustes[0][$j]['e3'];
        }
    }
}

