<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowMotor extends Component
{
    use WithFileUploads;
    public $motor;
    public $equipo,$statuses,$newStatus,$full_gallery=false;
    public $doc,$photo;
    protected $listeners = ['removeDoc'];

    public function mount(Motor $motor)
    {
        $this->motor = $motor;
        $this->equipo = $motor->equipo;
        $this->statuses = Status::all();
    }

    public function render()
    {
        return view('livewire.motors.show-motor')->with(["Carbon" => 'Carbon\Carbon']);
    }
    public function loadStatusModal(Motor $motor)
    {
        $this->equipo = $motor;
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
        $folderPath = '/uploads/' . "2M" . $this->motor->year . '-' . $this->motor->os . '/Documentos';
        
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
        $folderPath = '/uploads/' . "2M" . $this->motor->year . '-' . $this->motor->os . '/Fotos/Proceso';
        
        $this->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $uniqueFileName = $this->photo->getClientOriginalName();
        $this->photo->storeAs($folderPath, $uniqueFileName, 'public');

        $foto = $this->motor->fotos()->create([
            'titulo' => $uniqueFileName,
            'foto' => $folderPath . '/' . $uniqueFileName,
            'thumb' => $folderPath . '/' . $uniqueFileName,
            'type' => 2,
            'user_id' => auth()->id(),
        ]);
        
        $this->photo = null;
        $this->motor = Motor::find($this->motor->id_motor);
        $this->full_gallery = true;
        $this->render();
        
    }
    
}
