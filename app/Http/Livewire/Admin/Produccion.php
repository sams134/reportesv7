<?php

namespace App\Http\Livewire\Admin;

use App\Models\OtherWork;
use Carbon\Carbon;
use Livewire\Component;

class Produccion extends Component
{
    public $user;
    public $initial_date, $initial_day;
    public $final_date;
    public $week_selected = 0;
    public $horas_extras, $produccion;
    public $work,$otherWorks;
    const LUNES = 1;
    const MARTES = 2;
    const MIERCOLES = 3;
    const JUEVES = 4;
    const VIERNES = 5;
    const SABADO = 6;
    const DOMINGO = 7;

    protected $listeners = [
        'deleteWork' => 'deleteWork',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->week_selected = 0;
        $this->initial_day = self::JUEVES;
       
    }
    public function render()
    {
        $targetDay = ($this->initial_day == self::DOMINGO) ? 0 : $this->initial_day;
        $baseDate = Carbon::now()->previous($targetDay);
        $initialDate = $baseDate->copy()->addWeeks($this->week_selected);
        $this->initial_date = $initialDate;
        $this->final_date = $initialDate->copy()->addDays(7)->subSecond();

        $horas_extra = $this->user->horasExtras($this->initial_date, $this->final_date);
        $this->horas_extras = $horas_extra;
        $this->produccion = $this->user->produccion($this->initial_date, $this->final_date);

        $this->otherWorks = OtherWork::where('user_id', $this->user->id)
            ->whereBetween('fecha', [$this->initial_date, $this->final_date])
            ->get();
        return view('livewire.admin.produccion');
    }
    public function addWork()
    {
        OtherWork::create([
            'descripcion' => $this->work,
            'fecha' => now(),
            'pago' => 0,
            'user_id' => $this->user->id,
        ]);
        $this->work = '';
    }
    public function deleteWork($id)
    {
        OtherWork::destroy($id);
    }
}
