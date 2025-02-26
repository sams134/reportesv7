<?php

namespace App\Http\Livewire\Motors;

use App\Models\Foto;
use App\Models\Status;
use App\Models\TipoTrabajo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as Img;

class CreateFin extends Component
{
    use WithFileUploads;
    public $motor, $photo;
    public $participacion = [];
    public $participacionTecnicos = [];
    public $participacionHelp = [];
    public $participacionAyudantes = [];
    public $cantTecnicos = 0,$cantAyudantes = 0;
    protected $isUpdating = false; // Bandera para evitar recursión
    public $tipo_trabajos,$tipo_trabajo_id;

    public $listeners = ['saveFin','render'];
    protected $rules = [
        'photo' => 'required|image', // 1MB Max
    ];

    public function mount($motor)
    {
        $this->motor = $motor;
        $this->tipo_trabajos = TipoTrabajo::all();
        $this->tipo_trabajo_id = $motor->id_trabajo;
        $this->cantTecnicos = $motor->tecnicos->count();
        $this->cantAyudantes = $motor->ayudantes->count();
        // Inicializar los sliders de forma equitativa
        foreach ($motor->tecnicos as $tecnico) {
            $this->participacion[$tecnico->id] = round(100 / $this->cantTecnicos, 2);
            $this->participacionTecnicos[$tecnico->id] = round(100 / $this->cantTecnicos, 2);
        }
        foreach ($motor->ayudantes as $ayudante) {
            $this->participacionHelp[$ayudante->id] = round(100 / $this->cantAyudantes, 2);
            $this->participacionAyudantes[$ayudante->id] = round(100 / $this->cantAyudantes, 2);
        }
    }

    // Este método se ejecuta cada vez que se actualice un slider
    public function updatedParticipacion($value, $propertyName)
    {
        if ($this->cantTecnicos > 1) {
            $difference = $this->participacion[$propertyName] - $this->participacionTecnicos[$propertyName];
            $difference = $difference / ($this->cantTecnicos - 1);
            foreach ($this->participacionTecnicos as $id => $value) {
            if ($id != $propertyName) {
                $this->participacion[$id] = $this->participacionTecnicos[$id] - $difference;
            }
            }
        }
    }
    public function updatedParticipacionHelp($value, $propertyName)
    {
        if ($this->cantAyudantes > 1) {
            $difference = $this->participacionHelp[$propertyName] - $this->participacionAyudantes[$propertyName];
            $difference = $difference / ($this->cantAyudantes - 1);
            foreach ($this->participacionAyudantes as $id => $value) {
            if ($id != $propertyName) {
                $this->participacionHelp[$id] = $this->participacionAyudantes[$id] - $difference;
            }
            }
        }
    }
    public function saveFin()
    {
        $this->validate();
        
        $folderPath = '/uploads/' . $this->motor->year. '-' . $this->motor->os . '/fin';
        $photo = $this->photo;
        $image = Img::make($photo);

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
        $uniqueName = uniqid('img_', true) . '.' . $photo->getClientOriginalExtension();

        // Definir la ruta de la imagen
        $imagePath = $folderPath . '/' . $uniqueName;

        // Guardar la imagen usando el Storage
        Storage::disk('public')->put($imagePath, (string) $image->encode());
        $this->motor->fin = now();
        $this->motor->status_id = Status::FINALIZADO;
        $this->motor->id_trabajo = $this->tipo_trabajo_id;
        $this->motor->save();
        foreach($this->motor->tecnicos as $tecnico){
            $this->motor->tecnicos()->updateExistingPivot($tecnico->id, ['responsabilidad' => (double)$this->participacion[$tecnico->id]]);
        }
        foreach($this->motor->ayudantes as $ayudante){
            $this->motor->ayudantes()->updateExistingPivot($ayudante->id, ['responsabilidad' => (double)$this->participacionHelp[$ayudante->id]]);
        }
        $this->motor->fotos()->create([
            'foto' => $imagePath,
            'thumb' => $imagePath,
            'titulo' => 'Equipo finalizado',
            'user_id' => auth()->id(),
            'type' => Foto::FIN,
        ]);
        $this->emit('motorFinalizado');
    }

    public function render()
    {
        
        return view('livewire.motors.create-fin');
    }
}
