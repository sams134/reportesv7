<?php

namespace App\Http\Livewire;

use App\Models\Animal;
use Livewire\Component;

class DashboardView extends Component
{
    public function render()
    {
        $active = Animal::whereHas('status',function ($q){
            $q->where('is_active',true);
        })->get();
        return view('livewire.dashboard-view',compact('active'));
    }
}
