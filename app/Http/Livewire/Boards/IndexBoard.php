<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Intervention\Image\Facades\Image;
use App\Models\Motor;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class IndexBoard extends Component
{
    use WithFileUploads;
    public $board, $photo;
    public $camera_id_motor;
    protected $listeners = ['cameraLoaded'];
    protected $rules = [
        'photo' => 'required|image|max:51200', // 50MB en kilobytes
    ];
    public function mount(Board $board)
    {
        $this->board = $board;
    }
    public function render()
    {
        return view('livewire.boards.index-board');
    }
    public function cameraLoaded($id_motor)
    {
        $this->camera_id_motor = $id_motor;
    }
    public function updatedPhoto()
    {
        ini_set('memory_limit', '256M');
   
       $this->validate();
        $motor = Motor::find($this->camera_id_motor);
        if ($this->photo != "") {
            $image = Image::make($this->photo);

            // Corregir la orientación basada en los metadatos EXIF
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

            // Generar un nombre único para la imagen
            $uniqueName = uniqid('img_', true) . '.' . $this->photo->getClientOriginalExtension();

            $folderPath = '/uploads/' . "2M" . $motor->year . '-' . $motor->os . '/Fotos/Proceso';
            // Definir la ruta de la imagen
            $imagePath = $folderPath . '/' . $uniqueName;
            Storage::disk('public')->put($imagePath, (string) $image->encode());




            $foto = $motor->fotos()->create([
                'titulo' => $uniqueName,
                'foto' => $folderPath . '/' . $uniqueName,
                'thumb' => $folderPath . '/' . $uniqueName,
                'type' => 2,
                'user_id' => auth()->id(),
            ]);
            $this->emit('photoAdded', $motor->fullos);
        }
        $this->photo = null;
    }
}
