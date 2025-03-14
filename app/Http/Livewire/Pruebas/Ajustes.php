<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use App\Models\MotorAjuste;
use App\Models\OptionTornero;
use Livewire\Component;

class Ajustes extends Component
{
    public $ajustes, $motor, $allowed_initial = true, $allowed_final = true;
    public $decisiones,$options;
    public function mount(Motor $motor)
    {
        $this->decisiones = OptionTornero::all();
        $this->motor = Motor::find($motor->id_motor);
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
                $this->ajustes[$i][$j]['ax'] = $rod?$rod->ax:null;
                $this->ajustes[$i][$j]['ay'] = $rod?$rod->ay:null;
                $this->ajustes[$i][$j]['bx'] = $rod?$rod->bx:null;
                $this->ajustes[$i][$j]['by'] = $rod?$rod->by:null;
                if ($rod && $this->ajustes[$i][$j]['rod']->rodamiento->diametro_externo < 141) {
                   
                    $this->ajustes[$i][$j]['cx'] = $rod?($rod->bx+$rod->ax)/2:null;
                    $this->ajustes[$i][$j]['cy'] = $rod?($rod->by+$rod->ay)/2:null;
                }else{
                    $this->ajustes[$i][$j]['cx'] = $rod?$rod->cx:null;
                $this->ajustes[$i][$j]['cy'] = $rod?$rod->cy:null;
                }
                $this->ajustes[$i][$j]['designacion'] = $rod?$this->printDesignacion($rod):null;
                $this->options[$i][$j]['id'] = $rod?$rod->options_tornero_id:null;
                $this->options[$i][$j]['decision'] = $rod?$rod->recomendacion:null;
            }
        }
        //dd($this->ajustes);
    }

    public function render()
    {
        
        return view('livewire.pruebas.ajustes');
    }

    public function saveMedidas($i, $j)
    {
       
        try {
            $this->validate([
            'ajustes.' . $i . '.' . $j . '.ax' => 'required',
            'ajustes.' . $i . '.' . $j . '.ay' => 'required',
            'ajustes.' . $i . '.' . $j . '.bx' => 'required',
            'ajustes.' . $i . '.' . $j . '.by' => 'required',
            'ajustes.' . $i . '.' . $j . '.rod.options_tornero_id' => 'nullable',
            ]);
            if ($this->ajustes[$i][$j]['rod']['rodamiento']['diametro_externo'] > 141) {
                $this->validate([
                    'ajustes.' . $i . '.' . $j . '.cx' => 'required',
                    'ajustes.' . $i . '.' . $j . '.cy' => 'required',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->mount($this->motor);
            throw $e;
        }
        
        

        $rod = $this->motor->ajustes->where('carga_opuesto', $j)->where('initial_final', $i)->first();
        $this->ajustes[$i][$j]['rod'] = $rod;
        $this->ajustes[$i][$j]['rod']->ax = $this->ajustes[$i][$j]['ax'];
        $this->ajustes[$i][$j]['rod']->ay = $this->ajustes[$i][$j]['ay'];
        $this->ajustes[$i][$j]['rod']->bx = $this->ajustes[$i][$j]['bx'];
        $this->ajustes[$i][$j]['rod']->by = $this->ajustes[$i][$j]['by'];
        $this->ajustes[$i][$j]['rod']->cx = $this->ajustes[$i][$j]['cx'] ? $this->ajustes[$i][$j]['cx'] : ($this->ajustes[$i][$j]['ax'] + $this->ajustes[$i][$j]['bx']) / 2;
        $this->ajustes[$i][$j]['rod']->cy = $this->ajustes[$i][$j]['cy'] ? $this->ajustes[$i][$j]['cy'] : ($this->ajustes[$i][$j]['ay'] + $this->ajustes[$i][$j]['by']) / 2;
        $this->ajustes[$i][$j]['rod']->options_tornero_id = $this->options[$i][$j]['id'];
        $this->ajustes[$i][$j]['rod']->recomendacion = $this->options[$i][$j]['decision'];
        $this->ajustes[$i][$j]['rod']->user_medida_id = auth()->user()->id;
        $this->ajustes[$i][$j]['rod']->user_decision_id = auth()->user()->id;
        $this->ajustes[$i][$j]['rod']->save();
        $inicial_final = $i == 0 ? 'iniciales' : 'finales';
        $carga_opuesto = $j == 0 ? 'de carga ' : 'opuesto a la carga ';
        $this->mount($this->motor);
        $this->emit('savedMedidas', "Se actualizaron las medidas $inicial_final del lado $carga_opuesto");
    }

    public function finalizar()
    {
       $error = "";
       if (!$this->allowed_initial)
            return $this->emit('errorAlojamiento', "No se han registrado las medidas iniciales del rodamiento");
        if (!$this->allowed_final)
            return $this->emit('errorAlojamiento', "No se han registrado las medidas finales del rodamiento");
            for ($i = 0; $i < 2; $i++) {
                for ($j = 0; $j < 2; $j++) {
                    if (! $this->ajustes[$i][$j]['rod'])
                        return $this->emit('errorAlojamiento', "No se han registrado las medidas " . ($i == 0 ? 'iniciales' : 'finales') . " del rodamiento " . ($j == 0 ? 'de carga ' : 'opuesto a la carga '));
                        
                        try {
                            $this->validate([
                                'ajustes.' . $i . '.' . $j . '.ax' => 'required',
                                'ajustes.' . $i . '.' . $j . '.ay' => 'required',
                                'ajustes.' . $i . '.' . $j . '.bx' => 'required',
                                'ajustes.' . $i . '.' . $j . '.by' => 'required',
                                'ajustes.' . $i . '.' . $j . '.rod.options_tornero_id' => 'nullable',
                                ]);
                                if ($this->ajustes[$i][$j]['rod']['rodamiento']['diametro_externo'] > 141) {
                                    $this->validate([
                                        'ajustes.' . $i . '.' . $j . '.cx' => 'required',
                                        'ajustes.' . $i . '.' . $j . '.cy' => 'required',
                                    ]);
                                }
                        } catch (\Illuminate\Validation\ValidationException $e) {
                            $this->mount($this->motor);
                            
                            return $this->emit('errorAlojamiento', "No se han registrado las medidas " . ($i == 0 ? 'iniciales' : 'finales') . " del rodamiento " . ($j == 0 ? 'de carga ' : 'opuesto a la carga '));
                        }
                        try{
                            $this->validate([
                                'options.' . $i . '.' . $j . '.id' => 'required',
                            ]);
                        }catch (\Illuminate\Validation\ValidationException $e) {
                            $this->mount($this->motor);
                             return $this->emit('errorAlojamiento', "No se ha registrado la decisión para el alojamiento " . ($j == 0 ? 'de carga ' : 'opuesto a la carga ') . ($i == 0 ? 'inicial' : 'final'));
                        }
                        
                }
            }
       
       
      
    }

    public static function findMin($ajustesIngresados) {
        array_shift($ajustesIngresados);
        array_pop($ajustesIngresados);
        return min($ajustesIngresados);
    }
    public static function findMax($ajustesIngresados) {
        array_pop($ajustesIngresados);
        array_shift($ajustesIngresados);
        
        return max($ajustesIngresados);
    }
    public static function findMean($ajustesIngresados) {
        array_shift($ajustesIngresados);
        array_pop($ajustesIngresados);
        return array_sum($ajustesIngresados) / count($ajustesIngresados);
    }
    public static function findDeviation($ajustesIngresados) {
       
        return number_format((self::findMax($ajustesIngresados) - self::findMin($ajustesIngresados)) / self::findMean($ajustesIngresados) * 1000, 2);
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
}
