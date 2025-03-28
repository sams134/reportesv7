<?php

namespace App\Http\Livewire\Motors;

use App\Models\Config;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Motor;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as IMG;



class CreateJob extends Component
{
    use WithFileUploads;
    public $motor, $jobTypes, $year, $jobos, $jobTypeSelected, $jobRecord, $usersToAsign;
    public $tecnicoSelected = [], $photo;
    public $value_campo1, $value_campo2;

    public function mount(Motor $motor)
    {
        $this->motor = $motor;
        $this->jobTypes = JobType::all();
        $this->year = Config::find(1)->year;
    }
    public function updatedJobTypeSelected()
    {
        $this->jobRecord = JobType::find($this->jobTypeSelected);
        $this->jobos = Job::where('year', $this->jobRecord->prefix . $this->year)->max('os');
        $this->jobos = $this->jobos == null ? 1 : $this->jobos + 1;
        $usersTypes = explode(',', $this->jobRecord->userTypes);
        $this->usersToAsign = User::whereIn('userType', $usersTypes)->get();
    }
    public function cancel()
    {
        return redirect()->route('motores.show', $this->motor);
    }
    public function saveJob()
    {
        if ($this->jobRecord->campo2) {
            $this->validate([
                'photo' => 'required|image',
                'value_campo1' => 'required',
                'value_campo2' => 'required',
                'tecnicoSelected' => 'required|array|min:1',
            ]);
        } else {
            $this->validate([
                'photo' => 'required|image',
                'value_campo1' => 'required',
                'tecnicoSelected' => 'required|array|min:1',
            ]);
        }
        $folderPath = '/uploads/' . $this->jobRecord->prefix . $this->year . '-' . $this->jobos . '/Fotos';

        
        try {
            $image = IMG::make($this->photo);
            if ($image->exif('Orientation')) {
                $orientation = $image->exif('Orientation');
                switch ($orientation) {
                    case 3:
                        $image->rotate(180); // Rotar 180 grados
                        break;
                    case 6:
                        $image->rotate(-90); // Rotar 90 grados en sentido horario
                        break;
                    case 8:
                        $image->rotate(90); // Rotar 90 grados en sentido antihorario
                        break;
                }
            }
            // Redimensionar la imagen
            $image->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $uniqueName = uniqid('img_', true) . '.' . $this->photo->getClientOriginalExtension();
            $imagePath = $folderPath . '/' . $uniqueName;
            Storage::disk('public')->put($imagePath, (string) $image->encode());
            $this->jobos = Job::where('year', $this->jobRecord->prefix . $this->year)->max('os');
            $this->jobos = $this->jobos == null ? 1 : $this->jobos + 1;
            $job = Job::create([
                'id_motor' => $this->motor->id_motor,
                'job_type_id' => $this->jobRecord->id,
                'os' => $this->jobos,
                'year' => $this->jobRecord->prefix . $this->year,
                'value_campo1' => $this->value_campo1,
                'value_campo2' => $this->value_campo2,
            ]);
            $comentario = $this->jobRecord->name.' '.$this->jobRecord->campo1.':' . $this->value_campo1 . ' ' . $this->jobRecord->campo2 . ':' . $this->value_campo2;
            $imgCreated = $job->images()->create([
                'image' => $imagePath,
                'comentario' => $comentario,
                'user_id' => auth()->user()->id,
            ]);
            foreach ($this->tecnicoSelected as $id => $selected) {
                if ($selected) {
                    $job->usersAssigned()->attach($selected, ['assigned_by' => auth()->user()->id]);
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
       
        return redirect()->route('motores.show', $this->motor)->with('success', 'Adicionamos el trabajo ' . $job->year . '-' . $job->os . ', al equipo ' . $this->motor->year . '-' . $this->motor->os);
    }
    public function render()
    {
        return view('livewire.motors.create-job');
    }
}
