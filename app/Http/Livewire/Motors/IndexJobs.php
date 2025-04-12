<?php

namespace App\Http\Livewire\Motors;

use App\Models\Job;
use Livewire\Component;

class IndexJobs extends Component
{
    public $type,$jobs,$title;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $job = Job::find($id);
        if ($job) {
            $job->delete();
           // $this->jobs = $this->jobs->filter(fn($job) => $job->id !== $id);
           $this->mount($this->type);
        }
    }

    public function mount($type)
    {
        $this->type = $type;
        switch ($type) {
            case 'all':
                $this->jobs = Job::all();
                break;
            case 'tornos':
                $this->jobs = Job::where('year', 'like', 'TOR%')->get();
                $this->title = 'Trabajos de Tornos';
                break;
            case 'balanceos':
                $this->jobs = Job::where('year', 'like', 'BAL%')->get();
                $this->title = 'Balanceos dinamicos';
                break;
            case 'metalizados':
                $this->jobs = Job::where('year', 'like', 'MET%')->get();
                $this->title = 'Metalizados en frio';
                break;
            case 'soldaduras':
                $this->jobs = Job::where('year', 'like', 'WEL%')->get();
                $this->title = 'Soldaduras o reconstrucciones';
                break;
            default:
                $this->jobs = Job::all();
                break;
        }
     
    }
    public function render()
    {
        return view('livewire.motors.index-jobs');
    }
}
