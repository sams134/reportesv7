<?php

namespace App\Http\Livewire\Motors;

use App\Models\Image;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as IMG;

class EditJob extends Component
{
    use WithFileUploads;
    public $job, $photo, $jobTypes, $year, $jobos, $jobTypeSelected, $jobRecord, $usersToAsign;
    public $value_campo1, $value_campo2, $tecnicoSelected = [];

    protected $listeners = ['deleteImage'];

    public function mount(Job $job)
    {
        $this->job = Job::find($job->id);
        $this->jobTypes = JobType::all();
        $year = $this->job->year;
        $this->jobTypeSelected = $this->job->jobType->id;
        $this->jobRecord = JobType::find($this->job->jobType->id);
        $prefix = $this->jobRecord->prefix;
        $this->year = explode($prefix, $year)[1];
        $this->value_campo1 = $this->job->value_campo1;
        $this->value_campo2 = $this->job->value_campo2;
        $this->jobos = $this->job->os;
        $usersTypes = explode(',', $this->jobRecord->userTypes);
        $this->usersToAsign = User::whereIn('userType', $usersTypes)->get();
        $this->tecnicoSelected = $this->job->usersAssigned->pluck('id')->toArray();
    }
    public function render()
    {
        return view('livewire.motors.edit-job');
    }
    public function updatedJobTypeSelected()
    {
        $this->jobRecord = JobType::find($this->jobTypeSelected);
        if ($this->jobRecord->prefix == $this->job->jobType->prefix) {
            $this->jobos = $this->job->os;
        } else {
            $this->jobos = Job::where('year', $this->jobRecord->prefix . $this->year)->max('os');
            $this->jobos = $this->jobos == null ? 1 : $this->jobos + 1;
        }
        $tecnicoSelected = [];
        $usersTypes = explode(',', $this->jobRecord->userTypes);
        $this->usersToAsign = User::whereIn('userType', $usersTypes)->get();
    }
    public function deleteImage($id)
    {
        $image = Image::find($id);
        if ($image) {
            $image->delete();
            $this->job->images = $this->job->images->filter(fn($image) => $image->id !== $id);
        }
    }
    public function cancel()
    {
        return redirect()->route('motores.show', $this->job->motor);
    }
    public function saveJob()
    {
        if ($this->jobRecord->campo2) {
            $this->validate([
                'photo' => 'nullable|image',
                'value_campo1' => 'required',
                'value_campo2' => 'required',
                'tecnicoSelected' => 'required|array|min:1',
            ]);
        } else {
            $this->validate([
                'photo' => 'nullable|image',
                'value_campo1' => 'required',
                'tecnicoSelected' => 'required|array|min:1',
            ]);
        }

        try {
            if ($this->photo) {
                $folderPath = '/uploads/' . $this->jobRecord->prefix . $this->year . '-' . $this->jobos . '/Fotos';
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
            }
            $this->job->update([
                'job_type_id' => $this->jobTypeSelected,
                'os' => $this->jobos,
                'year' => $this->jobRecord->prefix . $this->year,
                'value_campo1' => $this->value_campo1,
                'value_campo2' => $this->value_campo2,
            ]);
            if ($this->photo) {
                $comentario = $this->jobRecord->name . ' ' . $this->jobRecord->campo1 . ':' . $this->value_campo1 . ' ' . $this->jobRecord->campo2 . ':' . $this->value_campo2;
               $this->job->images->first()->update([
                    'image' => $imagePath,
                    'comentario' => $comentario,
                    'user_id' => auth()->user()->id,
                ]);
            }
            $this->job->usersAssigned()->detach();
            foreach ($this->tecnicoSelected as $id => $selected) {
                if ($selected) {
                    $this->job->usersAssigned()->attach($selected, ['assigned_by' => auth()->user()->id]);
                }
            }
            $this->emit('jobUpdated', $this->job->id);
            return redirect()->route('motors.showJob', $this->job);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
