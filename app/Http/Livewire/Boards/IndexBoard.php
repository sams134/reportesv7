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
    public $comment;
    public $ver = "OS (Numero de Orden)", $pins;
    protected $listeners = ['cameraLoaded', 'deletePin'];
    protected $rules = [
        'photo' => 'required|image|max:51200', // 50MB en kilobytes
    ];
    public function mount(Board $board)
    {
        $this->board = $board;
        foreach ($this->board->pins as $pin) {
            $this->comment[$pin->id] = $pin->comment;
        }
    }
    public function render()
    {
        $this->pins = $this->board->pins()->with('pinable')->get();

        if ($this->ver == "OS (Numero de Orden)") {
            $this->pins = $this->pins->sortByDesc(function ($pin) {
            if ($pin->pinable_type === "App\\Models\\Motor") {
                return $pin->pinable->os;
            } elseif ($pin->pinable_type === "App\\Models\\Job") {
                return $pin->pinable->os;
            }
            // En caso de otro tipo, se puede retornar un valor predeterminado
            return 0;
            })->values(); // values() reindexa la colección
        }elseif ($this->ver == "Fecha de Creación") {
            $this->pins = $this->pins->sortByDesc(function ($pin) {
            return $pin->id;
            })->values(); // values() reindexa la colección
        }elseif ($this->ver == "Cliente") {
            $this->pins = $this->pins->sortByDesc(function ($pin) {
                if ($pin->pinable_type === "App\\Models\\Motor") {
                    return $pin->pinable->cliente->cliente;
                } elseif ($pin->pinable_type === "App\\Models\\Job") {
                    return $pin->pinable->motor->cliente->cliente;
                }
                // En caso de otro tipo, se puede retornar un valor predeterminado
                return 0;
            })->values(); // values() reindexa la colección
        }

        return view('livewire.boards.index-board');
    }
    public function updatedComment($value, $propertyName)
    {
        // $propertyName debería tener un formato tipo "comment.{pinId}"
        $parts = explode('.', $propertyName);
        $pinId = end($parts); // Esto extrae el último segmento, que es el pin_id

        // Ahora, $value es el nuevo valor del comentario y $pinId es el índice que buscas.
        $pin = $this->board->pins()->find($pinId);
        if ($pin) {
            $pin->update([
                'comment' => $value,
            ]);
        }
    }
    public function deletePin($pinId)
    {
        $pin = $this->board->pins()->find($pinId);
        if ($pin) {
            $pin->delete();
        }
        $this->board = Board::find($this->board->id);
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
