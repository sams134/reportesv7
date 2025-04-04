<?php

namespace App\Http\Livewire\Motors;

use App\Models\Job;
use App\Models\Motor;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as IMG;

class ShowJob extends Component
{
    use WithFileUploads;
    public $motor,$job;
    public $full_gallery=true;
    public $photo;
    protected $listeners = ['render'];
    public function mount(Job $job){

        $this->job = $job;
        $this->motor = $job->motor;
    }
    public function updatedFullGallery()
    {
        $this->dispatchBrowserEvent('init-swiper');
    }
    public function updatedPhoto()
    {
        $folderPath = '/uploads/' . $this->job->fullos. '/Fotos';
        
        $this->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

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
            $imgCreated = $this->job->images()->create([
                'image' => $imagePath,
                'comentario' => 'Avance de '.$this->job->jobType->name,
                'user_id' => auth()->user()->id,
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
        $this->photo = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->job = Job::find($this->job->id);
        $this->full_gallery = true;
        $this->render();
        
    }
    
    public function render()
    {
        return view('livewire.motors.show-job');
    }

    public function finalizarJob()
    {
        $this->job->finished = now();
        $this->job->save();
       /*  $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Trabajo Finalizado'
        ]); */
    }
}
