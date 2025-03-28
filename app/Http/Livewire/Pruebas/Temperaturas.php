<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use App\Models\Temperatura;
use Livewire\Component;

class Temperaturas extends Component
{
    public $motor, $cliente;
    public $time = 0;
    public $timeFormatted = '00:00:00:00'; // Variable para el tiempo formateado
    public $temperatures = ['time' => [], 'carga' => [], 'opuesto' => [], 'estator' => []];
    public $estator_t, $carga_t, $opuesto_t;
    public $isRunning = false;
    protected $listeners = ['updateTime'];


    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
        $this->cliente = $this->motor->cliente;
    }
    public function updateTime($time)
    {
        $this->time = $time;
        $hours = floor($time / 3600000);
        $minutes = floor(($time % 3600000) / 60000);
        $seconds = floor(($time % 60000) / 1000);
        $miliseconds = $time % 1000;
        $this->timeFormatted = sprintf('%02d:%02d:%02d:%02d', $hours, $minutes, $seconds, $miliseconds / 10);
    }

    public function registerTemp()
    {
        $this->validate([
            'carga_t' => 'required|numeric',
            'opuesto_t' => 'required|numeric',
            'estator_t' => 'required|numeric',
        ]);
        Temperatura::create([
            'id_motor' => $this->motor->id_motor,
            'carga' => $this->carga_t,
            'opuesto' => $this->opuesto_t,
            'estator' => $this->estator_t,
            'time' => $this->timeFormatted
        ]);
        $this->reset(['carga_t', 'opuesto_t', 'estator_t']);
        $this->emit('updateGraph');
    }
    public function start()
    {
        $this->isRunning = true;
    }
    public function stop()
    {
        $this->isRunning = false;
    }
    public function render()
    {
        return view('livewire.pruebas.temperaturas');
    }
    public function deleteTest()
    {
        Temperatura::where('id_motor', $this->motor->id_motor)->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->isRunning = false;
        $this->emit('updateGraph');
        
    }
    public function deleteTemp($id)
    {
        $temp = Temperatura::find($id);
        $temp->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->emit('updateGraph');
    }
    public function getTemperatures($id_motor)
    {
        $temperatures = Temperatura::where('id_motor', $id_motor)->get();
        foreach ($temperatures as $temperature) {
            $this->temperatures['time'][] = $temperature->time;
            $this->temperatures['carga'][] = $temperature->carga;
            $this->temperatures['opuesto'][] = $temperature->opuesto;
            $this->temperatures['estator'][] = $temperature->estator;
        }
        return response()->json($this->temperatures);
    }
}
