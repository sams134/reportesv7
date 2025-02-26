<?php

namespace App\Http\Livewire\Admin;

use App\Models\HorasExtra;
use App\Models\Motor;
use Carbon\Carbon;
use Livewire\Component;

class HorasExtras extends Component
{
    public $motor;
    public $authorized = false;
    public $init, $final, $hours, $description;
    public $existing;
    public function mount(Motor $motor)
    {
        $this->motor = $motor;
        // Primero, obtenemos la fecha que se usará para comparar si ya existe una hora extra
        $date = Carbon::parse($this->init)->format('Y-m-d');
        $existing = HorasExtra::where('user_id', auth()->id())
        ->whereDate('init', $date)
        ->first();
        $currentHour = (int) now()->format('H');
        $currentDay = now()->dayOfWeek; // Domingo: 0, Lunes: 1, ..., Sábado: 6

       $this->existing = $existing;

        if ($currentDay == Carbon::SATURDAY && !$existing) {
            // En sábado, autorizamos si es mediodía o después
            if ($currentHour >= 12 || $currentHour < 7) {
                $this->authorized = true;
                if ($currentHour < 7) {
                    $this->init = now()->subDay()->setTime(17, 0);
                } else {
                    $this->init = now()->setTime(12, 0);
                }
                $this->final = now();
                $this->hours = $this->final->diffInMinutes($this->init) / 60;
            }
        } elseif ($currentDay == Carbon::SUNDAY && $currentHour < 7 && !$existing) {
            // En domingo temprano, consideramos el inicio desde sábado a las 12:00
            $this->authorized = true;
            $this->init = now()->subDay()->setTime(12, 0);
            $this->final = now();
            $this->hours = $this->final->diffInMinutes($this->init) / 60;
        } elseif (!$existing) {
            // Para el resto de los días (de lunes a viernes o domingo después de las 7)
            if ($currentHour >= 17 || $currentHour < 7) {
                $this->authorized = true;
                if ($currentHour < 7) {
                    $this->init = now()->subDay()->setTime(17, 0);
                } else {
                    $this->init = now()->setTime(17, 0);
                }
                $this->final = now();
                $this->hours = $this->final->diffInMinutes($this->init) / 60;
            }
        }
    }


    public function render()
    {
        return view('livewire.admin.horas-extras');
    }

    public function store()
    {

        $this->motor->horasExtras()->create([
            'init' => $this->init,
            'final' => $this->final,
            'hours' => $this->hours,
            'descripcion' => $this->description,
            'user_id' => auth()->id(),
            'autorizado_por' =>  auth()->id(),
        ]);
        $this->emit('horas-extra-created');
        $this->emit('render');
    }
}
