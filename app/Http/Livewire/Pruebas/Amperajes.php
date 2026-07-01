<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use App\Models\NoLoadAmp;
use Livewire\Component;

class Amperajes extends Component
{
    public $tested = false;
    public $data_origin, $voltaje_placa, $amperaje_placa = 1, $voltaje_1, $amperaje_1, $voltaje_2, $amperaje_2, $voltaje_3, $amperaje_3;
    public $conexion_placa, $conexion_realizada;
    public $circuitos_placa, $circuitos_prueba, $rpm_placa, $rpm_prueba, $hz_placa, $hz_prueba, $polos;
    public $noLoadTest;
    public $motor;
    public $isVoltageBalanced = false, $pt = 1, $usePT = false, $ct = 1, $force_ct = true, $force_pt = true, $fct = 1, $fpt = 1, $limit_min, $limit_max;
    public $promA, $promV, $inbalance = 2, $desbalanceV, $desbalanceA;
    public $amps_comment;
    public $v1, $v2, $v3, $a1, $a2, $a3, $c1, $c2, $c3, $con, $circ, $noLoadAmps, $recorded = false;

    protected $listeners = [
        'deleteTestNameplate' => 'deleteTestNameplate',
        'deleteTest' => 'deleteTest',
    ];

    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
        $this->noLoadAmps = NoLoadAmp::all();
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
            $this->isVoltageBalanced = ($this->noLoadTest->useBalanced == 0) ? false : true;
            $this->fct = $this->ct = $this->noLoadTest->ct;
            $this->fpt = $this->pt = $this->noLoadTest->pt;
            $this->amps_comment = $this->noLoadTest->amps_comment;
            $this->recorded = $this->noLoadTest->recorded == 1 ? true : false;
            if ($this->fct != 1 || $this->fpt != 1)
                $this->usePT = true;
            else
                $this->usePT = false;
            $this->tested = $this->computeTested();

            $this->pt = $this->ct = 1;
        }
    }
    public function render()
    {

        if ($this->tested) {

            $this->circ = $this->circuitos_prueba;
            $this->con = $this->conexion_realizada;
            $this->promA = ($this->amperaje_1 + $this->amperaje_2 + $this->amperaje_3) / 3;
            $this->promV = ($this->voltaje_1 + $this->voltaje_2 + $this->voltaje_3) / 3;
            $this->desbalanceV = max($this->voltaje_1, $this->voltaje_2, $this->voltaje_3) - min($this->voltaje_1, $this->voltaje_2, $this->voltaje_3);
            $this->desbalanceV = ($this->desbalanceV / $this->promV) * 100;
            $this->desbalanceA = max($this->amperaje_1, $this->amperaje_2, $this->amperaje_3) - min($this->amperaje_1, $this->amperaje_2, $this->amperaje_3);
            $this->desbalanceA = ($this->desbalanceA / $this->promA) * 100;
            $this->v1 = $this->isVoltageBalanced ? number_format($this->promV * (1 - $this->inbalance / 100), 1) : number_format($this->voltaje_1, 1);
            $this->v2 = $this->isVoltageBalanced ? number_format($this->promV, 1) : number_format($this->voltaje_2, 1);
            $this->v3 = $this->isVoltageBalanced ? number_format($this->promV * (1 + $this->inbalance / 100), 1) : number_format($this->voltaje_3, 1);
            $this->a1 = $this->isVoltageBalanced ? number_format($this->promA * (1 - $this->inbalance / 100), 1) : number_format($this->amperaje_1, 1);
            $this->a2 = $this->isVoltageBalanced ? number_format($this->promA, 1) : number_format($this->amperaje_2, 1);
            $this->a3 = $this->isVoltageBalanced ? number_format($this->promA * (1 + $this->inbalance / 100), 1) : number_format($this->amperaje_3, 1);
            $this->c1 = $this->isVoltageBalanced ? number_format(($this->promA * (1 - $this->inbalance * 2.1 / 100)) / $this->amperaje_placa * 100, 2) : number_format($this->amperaje_1 / $this->amperaje_placa * 100, 2);
            $this->c2 = $this->isVoltageBalanced ? number_format(($this->promA) / $this->amperaje_placa * 100, 2) : number_format($this->amperaje_2 / $this->amperaje_placa * 100, 2);
            $this->c3 = $this->isVoltageBalanced ? number_format(($this->promA * (1 + 2.1 * $this->inbalance / 100)) / $this->amperaje_placa * 100, 2) : number_format($this->amperaje_3 / $this->amperaje_placa * 100, 2);
            for ($i = 2; $i < 36; $i += 2) {
                $synchronusRpm = 2 * ($this->hz_placa * 60) / $i;
                if ($this->rpm_placa > $synchronusRpm) {
                    $this->polos = $i - 2;
                    break;
                }
            }
            $this->limit_max = NoLoadAmp::where('poles', $this->polos)->value('maxA');
            $this->limit_min = NoLoadAmp::where('poles', $this->polos)->value('minA');

            //$this->emit('testUpdated', number_format($this->promA / $this->amperaje_placa * 100 * $this->fct * $this->fpt, 1), $this->limit_min, $this->limit_max);
        }


        return view('livewire.pruebas.amperajes');
    }

    private function computeTested(): bool
    {
        if (!$this->noLoadTest) return false;

        // Campos mínimos para considerar "prueba completa"
        $required = [
            $this->voltaje_1,
            $this->voltaje_2,
            $this->voltaje_3,
            $this->amperaje_1,
            $this->amperaje_2,
            $this->amperaje_3,
            $this->rpm_prueba,
            $this->conexion_realizada,
            $this->circuitos_prueba,
        ];

        // Deben existir y no ser null (y no cadena vacía)
        foreach ($required as $v) {
            if ($v === null || $v === '') return false;
        }

        return true;
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
            //$this->emit('noLoadTestSaved', 4);
        } else {
            $this->motor->noLoadTest()->create($data);
            //$this->emit('noLoadTestSaved', 3);
        }
        $this->motor = Motor::find($this->motor->id_motor);
        $this->noLoadTest = $this->motor->noLoadTest;

        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Datos de placa guardados',
            'text'  => 'Los valores de placa se registraron correctamente.',
            'icon'  => 'success',
        ]);
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
        // refrescar para asegurar valores
        $this->motor = Motor::find($this->motor->id_motor);
        $this->noLoadTest = $this->motor->noLoadTest;

        $this->tested = true;
        // calcular valores
        $promA = ($this->amperaje_1 + $this->amperaje_2 + $this->amperaje_3) / 3;

        // calcular polos (mismo loop que render)
        $polos = null;
        for ($i = 2; $i < 36; $i += 2) {
            $synchronusRpm = 2 * ($this->hz_placa * 60) / $i;
            if ($this->rpm_placa > $synchronusRpm) {
                $polos = $i - 2;
                break;
            }
        }
        $this->polos = $polos;

        // límites
        $limitMax = NoLoadAmp::where('poles', $polos)->value('maxA') ?? 90;
        $limitMin = NoLoadAmp::where('poles', $polos)->value('minA') ?? 10;

        $valor = number_format($promA / $this->amperaje_placa * 100 * $this->fct * $this->fpt, 1);

        // ✅ ahora sí, dibujar
        $this->dispatchBrowserEvent('amperajes:drawGauge', [
            'valor' => $valor,
            'min' => $limitMin,
            'max' => $limitMax,
        ]);

        $this->tested = $this->computeTested();


        $this->emit('noLoadTestSaved', 2);
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
            'data_origin',
            'voltaje_placa',
            'amperaje_placa',
            'conexion_placa',
            'circuitos_placa',
            'rpm_placa',
            'hz_placa',
            'voltaje_1',
            'amperaje_1',
            'voltaje_2',
            'amperaje_2',
            'voltaje_3',
            'amperaje_3',
            'conexion_realizada',
            'circuitos_prueba',
            'rpm_prueba',
            'hz_prueba'
        ]);
        $this->noLoadTest = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->mount($this->motor);
    }

    public function getDeltaRpmPercentProperty()
    {
        if (empty($this->rpm_placa) || $this->rpm_placa == 0) {
            return null;
        }

        return abs($this->rpm_prueba - $this->rpm_placa) / $this->rpm_placa * 100;
    }

    public function getAmperajePercentProperty()
    {
        if (empty($this->amperaje_placa) || $this->amperaje_placa == 0) {
            return null;
        }

        return ($this->promA / $this->amperaje_placa) * 100 * $this->fct * $this->fpt;
    }

    public function balanceData()
    {
        $this->isVoltageBalanced = !$this->isVoltageBalanced;
        $this->noLoadTest->update([
            'useBalanced' => $this->isVoltageBalanced ? 1 : 0
        ]);
    }
    public function usePTFunc()
    {
        $this->usePT = !$this->usePT;
        if ((abs($this->voltaje_placa - $this->promV) > 0.2 * $this->voltaje_placa) && ($this->usePT)) {
            $this->pt = round($this->voltaje_placa / $this->promV, 1);
            $this->ct = $this->pt;
        }
        if (($this->conexion_realizada != $this->conexion_placa) && ($this->usePT)) {
            if ($this->conexion_realizada == 1) {
                $this->ct /= 1.732;
            } else {
                $this->ct *= 1.732;
            }
            $this->con = $this->conexion_placa;
        }
        if (($this->circuitos_placa != $this->circuitos_prueba) && ($this->usePT)) {
            $this->ct *= $this->circuitos_placa / $this->circuitos_prueba;
            $this->circ = $this->circuitos_placa;
        }
        $this->ct = round($this->ct, 2);
        $this->pt = round($this->pt, 2);

        $this->fct = $this->ct;
        $this->fpt = $this->pt;

        if (!$this->usePT) {
            $this->fct = $this->fpt = 1;
            $this->noLoadTest->update([
                'ct' => 1,
                'pt' => 1
            ]);
        } else {
            $this->noLoadTest->update([
                'ct' => $this->fct,
                'pt' => $this->fpt
            ]);
        }
    }
    public function change_forcePT()
    {
        $this->force_pt = !$this->force_pt;
        if (!$this->force_pt)
            $this->fpt = $this->pt;
    }
    public function change_forceCT()
    {
        $this->force_ct = !$this->force_ct;
        if (!$this->force_ct)
            $this->fct = $this->ct;
    }
    public function updatedFct($value)
    {
        $this->noLoadTest->update([
            'ct' => $this->fct
        ]);
    }
    public function updatedFpt($value)
    {
        $this->noLoadTest->update([
            'pt' => $this->fpt
        ]);
    }
    public function exportResults()
    {
        logger()->info('exportResults called', ['motor' => $this->motor->id_motor]);

        if (!$this->noLoadTest || !$this->tested) {
            $this->dispatchBrowserEvent('swal:alert', [
                'title' => 'Faltan datos',
                'text'  => 'Primero guarda los datos de la prueba para poder exportar resultados.',
                'icon'  => 'warning',
            ]);
            return;
        }

        $this->noLoadTest->update([
            'recorded' => 1,
            'finished' => now(),
            'id_user'  => auth()->id(),
        ]);

        $this->recorded = true;

        $promA = ($this->amperaje_1 + $this->amperaje_2 + $this->amperaje_3) / 3;

        $polos = null;
        for ($i = 2; $i < 36; $i += 2) {
            $synchronusRpm = 2 * ($this->hz_placa * 60) / $i;

            if ($this->rpm_placa > $synchronusRpm) {
                $polos = $i - 2;
                break;
            }
        }

        $limitMax = NoLoadAmp::where('poles', $polos)->value('maxA') ?? 90;
        $limitMin = NoLoadAmp::where('poles', $polos)->value('minA') ?? 10;

        $valor = round(($promA / $this->amperaje_placa) * 100 * $this->fct * $this->fpt, 1);

        $this->dispatchBrowserEvent('no-load-export', [
            'motor_id' => $this->motor->id_motor,
            'valor' => $valor,
            'min' => $limitMin,
            'max' => $limitMax,
        ]);
    }
    public function saveAmpsComment()
    {
        $this->noLoadTest->update([
            'amps_comment' => $this->amps_comment,
        ]);

        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Comentario guardado',
            'text'  => 'El comentario sobre los amperajes ha sido guardado.',
            'icon'  => 'success',
        ]);
    }
}
