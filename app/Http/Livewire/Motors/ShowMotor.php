<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as IMG;

class ShowMotor extends Component
{
    use WithFileUploads;
    public $motor;
    public $equipo,$statuses,$newStatus,$full_gallery=true;
    public $doc,$photo,$comment;
    public $finalizado = false;
    protected $listeners = ['removeDoc','render','motorFinalizado'=>'render'];

    public function mount(Motor $motor)
    {
        $this->motor = $motor;
        $this->equipo = $motor->equipo;
        $this->statuses = Status::all();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('init-swiper');
        if ($this->motor->fin)
          $finalizado = true;
        return view('livewire.motors.show-motor')->with(["Carbon" => 'Carbon\Carbon']);
    }
    public function loadStatusModal($id_motor)
    {
        $this->equipo = Motor::find($id_motor);
        $this->newStatus = $this->equipo->status_id;
  
    }
    public function updateStatus()
    {
        $this->validate([
            'newStatus' => 'required|exists:statuses,id',
        ]);

        $this->motor->status_id = $this->newStatus;
        $this->motor->save();
        
    }
    public function updatedDoc()
    {
        $folderPath = '/uploads/' . $this->motor->year . '-' . $this->motor->os . '/Documentos';
        
        $this->validate([
            'doc' => 'required|file|mimes:pdf',
        ]);

        $uniqueFileName = $this->doc->getClientOriginalName();
        $this->doc->storeAs($folderPath, $uniqueFileName, 'public');

        $document = $this->motor->documentos()->create([
            'titulo' => $uniqueFileName,
            'documento' => $folderPath . '/' . $uniqueFileName,
            'id_user' => auth()->id(),
        ]);
        
        $this->doc = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->render();
        
    }
    public function removeDoc($id)
    {
        $doc = $this->motor->documentos()->find($id);
        $doc->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->render();
    }
    public function updatedFullGallery()
    {
        $this->dispatchBrowserEvent('init-swiper');
    }
    public function updatedPhoto()
    {

        
        try {
            $this->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            
            
            if ($this->photo != "") {
            $image = IMG::make($this->photo);
                
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

            $folderPath = '/uploads/' . $this->motor->fullos . '/Fotos/Proceso';
            // Definir la ruta de la imagen
            $imagePath = $folderPath . '/' . $uniqueName;

            
            
            Storage::disk('public')->put($imagePath, (string) $image->encode());

            $foto = $this->motor->fotos()->create([
                'titulo' => $uniqueName,
                'foto' => $folderPath . '/' . $uniqueName,
                'thumb' => $folderPath . '/' . $uniqueName,
                'type' => 2,
                'user_id' => auth()->id(),
            ]);
            $this->emit('photoAdded', $this->motor->fullos);
            }
            $this->photo = null;
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
        }
       
        
        $this->photo = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->full_gallery = true;
        $this->render();
        
    }
    public function saveComment()
    {
        $this->validate([
            'comment' => 'required|string|max:255',
        ]);
        $titulo = '';
        switch (Auth::user()->userType) {
            case User::DEVELOPER:
                  $titulo = 'Comentario de Gerencia';
                break;
            case User::GERENCIA:
                  $titulo = 'Comentario de Gerencia';
                break;
            case User::ADMINISTRACION:
                  $titulo = 'Comentario de Administración';
                break;
            case User::BODEGA:
                  $titulo = 'Comentario de Bodega';
                break;
            case User::TORNOS:
                  $titulo = 'Comentario de Tornos';
                break;
            case User::TECNICO:
                  $titulo = 'Comentario de Técnico';
                break;
            case User::AYUDANTES:
                  $titulo = 'Comentario de Ayudantes';
                break;
            case User::PRUEBAS:
                  $titulo = 'Comentario de departamento de Pruebas';
                break;
            case User::PILOTOS:
                  $titulo = 'Comentario de Pilotos';
                break;
            case User::VENDEDORES:
                  $titulo = 'Comentario de Vendedores';
                break;
            case User::JEFE:
                  $titulo = 'Comentario de Jefe de Taller';
                break;
            case User::PINTURA:
                  $titulo = 'Comentario de Pintura';
                break;
        }
        $this->motor->bitacoras()->create([
            'titulo' => $titulo,
            'descripcion' => $this->comment,
            'id_usuario' => auth()->id(),
        ]);

        $this->comment = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->render();

    }
    
    
}
