<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;
use Intervention\Image\Facades\Image as IMG;

class UpdatePhoto extends Component
{
    use WithFileUploads;
    public $photo, $name, $email, $phone, $direccion;
    public function mount()
    {
        // $this->photo = auth()->user()->foto;
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->phone = auth()->user()->phone;
        $this->direccion = auth()->user()->direccion;
    }
    public function render()
    {
        return view('livewire.profile.update-photo');
    }
    public function updateProfile()
    {

        $this->validate([
            'photo' => 'nullable|image',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        
        $user = User::find(auth()->user()->id);
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->direccion = $this->direccion;
        
        if ($this->photo) {
            $folderPath = '/uploads/empleados/';
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
                $image->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $uniqueName = uniqid('img_', true) . '.' . $this->photo->getClientOriginalExtension();
                $imagePath = $folderPath . '/' . $uniqueName;
                Storage::disk('public')->put($imagePath, (string) $image->encode());
                $user->foto = $imagePath;
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
      
        try {
            
            $user->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        $this->emit('userUpdated');
    }
}
