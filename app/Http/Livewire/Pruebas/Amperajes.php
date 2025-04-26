<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use Livewire\Component;

class Amperajes extends Component
{
    public $tested = false;
    public $data_origin, $voltaje_placa, $amperaje_placa, $voltaje_1, $amperaje_1, $voltaje_2, $amperaje_2, $voltaje_3, $amperaje_3;
    public $conexion_placa, $conexion_realizada;
    public $circuitos_placa, $circuitos_prueba, $rpm_placa, $rpm_prueba, $hz_placa, $hz_prueba,$polos;
    public $noLoadTest;
    public $motor;
    public $isVoltageBalanced = false,$pt=1,$usePT=false;
    public $promA,$promV,$inbalance=2,$desbalanceV,$desbalanceA;
    public $v1,$v2,$v3,$a1,$a2,$a3,$c1,$c2,$c3;

    protected $listeners = [
        'deleteTestNameplate' => 'deleteTestNameplate',
        'deleteTest' => 'deleteTest',
    ];

    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
        $this->noLoadTest = $this->motor->noLoadTest;
        if ($this->noLoadTest) {
            $this->data_origin = $this->noLoadTest->origen;
            $this->voltaje_placa = $this->noLoadTest->voltaje_placa;
            $this->amperaje_placa = $this->noLoadTest->amperaje_placa;
            $this->conexion_placa = $this->noLoadTest->conexion_placa;
            $this->circuitos_placa = $this->noLoadTest->circuitos_placa;
            $this->rpm_placa = $this->noLoadTest->rpm_placa;
            $this->hz_placa = $this->noLoadTest->hz_placa;
            $this->voltaje_1 = $this->noLoadTest->volts_prueba_A;
            
            $this->voltaje_2 = $this->noLoadTest->volts_prueba_B;
            $this->voltaje_3 = $this->noLoadTest->volts_prueba_C;
            $this->amperaje_1 = $this->noLoadTest->amps_prueba_A;
            $this->amperaje_2 = $this->noLoadTest->amps_prueba_B;
            $this->amperaje_3 = $this->noLoadTest->amps_prueba_C;
            $this->conexion_realizada = $this->noLoadTest->conexion_prueba;
            $this->circuitos_prueba = $this->noLoadTest->circuitos_prueba;
            $this->rpm_prueba = $this->noLoadTest->rpm_prueba;
            $this->hz_prueba = $this->noLoadTest->hz_prueba;
            if ($this->voltaje_1 != null) {
                $this->tested = true;
               
            }
        }
       
    }
    public function render()
    {
        if ($this->tested){
            
            $this->promA = ($this->amperaje_1 + $this->amperaje_2 + $this->amperaje_3) / 3;
            $this->promV = ($this->voltaje_1 + $this->voltaje_2 + $this->voltaje_3) / 3;
            $this->desbalanceV = max($this->voltaje_1, $this->voltaje_2, $this->voltaje_3) - min($this->voltaje_1, $this->voltaje_2, $this->voltaje_3);
            $this->desbalanceV = ($this->desbalanceV / $this->promV) * 100;
            $this->desbalanceA = max($this->amperaje_1, $this->amperaje_2, $this->amperaje_3) - min($this->amperaje_1, $this->amperaje_2, $this->amperaje_3);
            $this->desbalanceA = ($this->desbalanceA / $this->promA) * 100;
            $this->v1 = $this->isVoltageBalanced?number_format($this->promV*(1-$this->inbalance/100), 1): number_format($this->voltaje_1, 1);
            $this->v2 = $this->isVoltageBalanced?number_format($this->promV, 1): number_format($this->voltaje_2, 1);
            $this->v3 = $this->isVoltageBalanced?number_format($this->promV*(1+$this->inbalance/100), 1): number_format($this->voltaje_3, 1);
            $this->a1 = $this->isVoltageBalanced?number_format($this->promA*(1-$this->inbalance/100), 1): number_format($this->amperaje_1, 1);
            $this->a2 = $this->isVoltageBalanced?number_format($this->promA, 1): number_format($this->amperaje_2, 1);
            $this->a3 = $this->isVoltageBalanced?number_format($this->promA*(1+$this->inbalance/100), 1): number_format($this->amperaje_3, 1);
            $this->c1 = $this->isVoltageBalanced?number_format(($this->promA*(1-$this->inbalance*2.1/100))/$this->amperaje_placa*100, 2): number_format($this->amperaje_1/$this->amperaje_placa*100, 2);
            $this->c2 = $this->isVoltageBalanced?number_format(($this->promA)/$this->amperaje_placa*100, 2): number_format($this->amperaje_2/$this->amperaje_placa*100, 2);
            $this->c3 = $this->isVoltageBalanced?number_format(($this->promA*(1+2.1*$this->inbalance/100))/$this->amperaje_placa*100, 2): number_format($this->amperaje_3/$this->amperaje_placa*100, 2);
            for ($i = 2; $i < 36; $i+=2) {
                $synchronusRpm = 2*($this->hz_placa * 60) / $i;
                if ($this->rpm_placa > $synchronusRpm) {
                    $this->polos = $i-2;
                    break;
                }
            }
            if ((abs($this->voltaje_placa - $this->promV) > 0.2 * $this->voltaje_placa) && ($this->usePT)) {
                $this->pt = round($this->voltaje_placa / $this->promV, 1);
                
            } else {
                $this->pt = 1;
            }
        }
        return view('livewire.pruebas.amperajes');
    }

    public function saveNameplate()
    {
        $this->validate([
            'data_origin' => 'required',
            'voltaje_placa' => 'required|numeric',
            'amperaje_placa' => 'required|numeric',
            'conexion_placa' => 'required',
            'circuitos_placa' => 'required|numeric',
            'rpm_placa' => 'required|numeric',
            'hz_placa' => 'required|numeric',
        ]);
        $data = [
            'origen' => $this->data_origin,
            'voltaje_placa' => $this->voltaje_placa,
            'amperaje_placa' => $this->amperaje_placa,
            'conexion_placa' => $this->conexion_placa,
            'circuitos_placa' => $this->circuitos_placa,
            'rpm_placa' => $this->rpm_placa,
            'hz_placa' => $this->hz_placa,
        ];
        if ($this->noLoadTest) {
            $this->noLoadTest->update($data);
            $this->emit('noLoadTestSaved', 4);
        } else {
            $this->motor->noLoadTest()->create($data);
            $this->emit('noLoadTestSaved', 3);
        }
    }

    public function saveTest()
    {
        $this->validate([
            'data_origin' => 'required',
            'voltaje_placa' => 'required|numeric',
            'amperaje_placa' => 'required|numeric',
            'conexion_placa' => 'required',
            'circuitos_placa' => 'required|numeric',
            'rpm_placa' => 'required|numeric',
            'hz_placa' => 'required|numeric',
            'voltaje_1' => 'required|numeric',
            'amperaje_1' => 'required|numeric',
            'voltaje_2' => 'required|numeric',
            'amperaje_2' => 'required|numeric',
            'voltaje_3' => 'required|numeric',
            'amperaje_3' => 'required|numeric',
            'conexion_realizada' => 'required',
            'circuitos_prueba' => 'required|numeric',
            'rpm_prueba' => 'required|numeric',
        ]);
        $data = [
            'origen' => $this->data_origin,
            'voltaje_placa' => $this->voltaje_placa,
            'amperaje_placa' => $this->amperaje_placa,
            'conexion_placa' => $this->conexion_placa,
            'circuitos_placa' => $this->circuitos_placa,
            'rpm_placa' => $this->rpm_placa,
            'hz_placa' => $this->hz_placa,
            'volts_prueba_A' => $this->voltaje_1,
            'volts_prueba_B' => $this->voltaje_2,
            'volts_prueba_C' => $this->voltaje_3,
            'amps_prueba_A' => $this->amperaje_1,
            'amps_prueba_B' => $this->amperaje_2,
            'amps_prueba_C' => $this->amperaje_3,
            'conexion_prueba' => $this->conexion_realizada,
            'circuitos_prueba' => $this->circuitos_prueba,
            'rpm_prueba' => $this->rpm_prueba,
        ];

        if (!$this->noLoadTest) {
            $this->motor->noLoadTest()->create($data);
            $this->noLoadTest = $this->motor->noLoadTest;
            $this->emit('noLoadTestSaved', 1);
        } else {
            $this->noLoadTest->update($data);
        }
        $this->emit('noLoadTestSaved', 2);
        $this->tested = true;
    }
    public function deleteTest()
    {
        $data = [
            'volts_prueba_A' => null,
            'volts_prueba_B' => null,
            'volts_prueba_C' => null,
            'amps_prueba_A' => null,
            'amps_prueba_B' => null,
            'amps_prueba_C' => null,
            'conexion_prueba' => null,
            'circuitos_prueba' => null,
            'rpm_prueba' => null,
        ];
        if ($this->noLoadTest) {
            $this->noLoadTest->update($data);
       
        }
        $this->tested = false;
        $this->mount($this->motor);
    }
    public function deleteTestNameplate()
    {

        $this->motor->noLoadTest()->delete();
        $this->tested = false;
        $this->reset([
            'data_origin', 'voltaje_placa', 'amperaje_placa', 'conexion_placa', 'circuitos_placa', 'rpm_placa', 'hz_placa',
            'voltaje_1', 'amperaje_1', 'voltaje_2', 'amperaje_2', 'voltaje_3', 'amperaje_3',
            'conexion_realizada', 'circuitos_prueba', 'rpm_prueba', 'hz_prueba'
        ]);
        $this->noLoadTest = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->mount($this->motor);
        
    }
    public function balanceData()
    {
        $this->isVoltageBalanced = !$this->isVoltageBalanced;
    }
    public function usePTFunc()
    {
        $this->usePT = !$this->usePT;
    }

}
