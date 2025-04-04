<?php

namespace App\Http\Livewire\Motors;

use App\Models\Job;
use App\Models\Motor;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;

class AsignacionesJobModal extends Component
{
    public $motor,$job; // Almacena el motor seleccionado
    public $tecnicos,$statuses,$ayudantes;
    protected $listeners = ['openAsignacionesJobModal'];
    public $tecnicoSelected = [];


    public function mount(Job $job)
    {
        $this->job = $job;
        $this->motor = $job->motor;
        $this->statuses = Status::all();
    }
    

    // Este método se ejecuta cuando se emite el evento con el ID del motor
    public function openAsignacionesJobModal($jobId)
    {
        
         $this->job = Job::find($jobId);
  
        // Inicializar el arreglo de técnicos seleccionados
        $this->tecnicoSelected = [];
        if ($this->job && $this->job->usersAssigned) {
            foreach ($this->job->usersAssigned as $tec) {
                // Marcamos como true para cada técnico asignado
                $this->tecnicoSelected[$tec->id] = true;
            }
        } 
        $this->dispatchBrowserEvent('show-modal');
    }
    public function saveAsignaciones()
    {
        $error = true;
        foreach ($this->tecnicoSelected as $id => $selected) {
            if ($selected) {
                $error = false;
                break;
            }
        }
        if ($error) {
            $this->dispatchBrowserEvent('show-error', ['message' => 'Debes seleccionar al menos un técnico']);
            return;
        }
        // Eliminar todas las asignaciones
        $this->job->usersAssigned()->detach();
        
       
        // Asignar los técnicos seleccionados
        foreach ($this->tecnicoSelected as $id => $selected) {
            if ($selected) {
                $this->job->usersAssigned()->attach($id, ['assigned_by' => auth()->user()->id]);
            }
        }
        
        $this->dispatchBrowserEvent('hide-modal');
        $this->emitTo('motors.show-job', 'render');
       
    }
    public function render()
    {
        $this->statuses = Status::all();

        $usersTypes = explode(',', $this->job->jobType->userTypes);
        $this->tecnicos = User::whereIn('userType', $usersTypes)
       
        ->orderBy('name')
        ->get();
       
        return view('livewire.motors.asignaciones-job-modal');
    }
}
