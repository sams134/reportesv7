<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use Livewire\Component;

class IndexMotors extends Component
{
    public function render()
    {
        $motores = Motor::orderBy('year','desc')->orderBy('os','desc')->paginate(30);
        
        //  return view('livewire.motors.index',compact('motores'));
        return view('livewire.motors.index-motors',compact('motores'));
    }
}
