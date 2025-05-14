<?php

namespace App\Http\Livewire\Motors;

use App\Models\Job;
use Livewire\Component;

class IndexJobs extends Component
{
    public $type,$title;

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
        
     
    }
    public function render()
    {
        switch ($this->type) {
            case 'all':
                $jobs = Job::all();
                break;
            case 'tornos':
                $jobs = Job::where('year', 'like', 'TOR%');
                $this->title = 'Trabajos de Tornos';
                break;
            case 'balanceos':
                $jobs = Job::where('year', 'like', 'BAL%');
                $this->title = 'Balanceos dinamicos';
                break;
            case 'metalizados':
                $jobs = Job::where('year', 'like', 'MET%');
                $this->title = 'Metalizados en frio';
                break;
            case 'soldaduras':
                $jobs = Job::where('year', 'like', 'WEL%');
                $this->title = 'Soldaduras o reconstrucciones';
                break;
            default:
                $jobs = Job::all();
                break;
        }
        $jobs = $jobs->orderBy('year', 'desc')
                ->orderBy('os', 'desc')
                ->paginate(30);
        return view('livewire.motors.index-jobs')->with([
            'jobs' => $jobs,
     
        ]);
    }
}
