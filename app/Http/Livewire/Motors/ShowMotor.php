<?php
// ShowMotor component actualizado para carga múltiple y procesamiento en segundo plano

namespace App\Http\Livewire\Motors;

use App\Jobs\ProcessMotorPhoto; // <–– nuevo Job
use App\Models\Motor;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowMotor extends Component
{
    use WithFileUploads;

    public $motor;
    public $equipo, $statuses, $newStatus, $full_gallery = true;
    public $doc, $comment;
    public bool $finalizado = false;

    /** @var array<int, Livewire\TemporaryUploadedFile> */
    public array $photos = []; // ⇦ ahora es un array de múltiples fotos

    protected $listeners = [
        'removeDoc',
        'render',
        'motorFinalizado' => 'render',
        'removePhoto'
    ];

    /** Validaciones */
    protected array $rules = [
        'photos.*' => 'image|mimes:jpeg,png,jpg,webp,gif,svg',
        'doc'      => 'nullable|file|mimes:pdf',
        'newStatus'=> 'nullable|exists:statuses,id',
        'comment'  => 'nullable|string|max:255',
    ];

    public function mount(Motor $motor): void
    {
        $this->motor    = $motor;
        $this->equipo   = $motor->equipo;
        $this->statuses = Status::all();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('init-swiper');
        if ($this->motor->fin) {
            $this->finalizado = true;
        }
        return view('livewire.motors.show-motor')->with(['Carbon' => 'Carbon\\Carbon']);
    }

    /* ------------------------- Subida de documentos PDF ------------------------- */

    public function updatedDoc(): void
    {
        $this->validateOnly('doc');

        $folderPath = sprintf('/uploads/%s-%s/Documentos', $this->motor->year, $this->motor->os);
        $uniqueFile = $this->doc->getClientOriginalName();

        $this->doc->storeAs($folderPath, $uniqueFile, 'public');

        $this->motor->documentos()->create([
            'titulo'    => $uniqueFile,
            'documento' => "$folderPath/$uniqueFile",
            'id_user'   => auth()->id(),
        ]);

        $this->reset('doc');
        $this->motor->refresh();
    }

    /* -------------------------- Subida de múltiples fotos -------------------------- */

    public function updatedPhotos(): void
    {
        $this->validateOnly('photos.*');

        foreach ($this->photos as $photo) {
            ProcessMotorPhoto::dispatch(
                $photo->getRealPath(),
                $photo->getClientOriginalName(),
                $this->motor->id_motor,
                auth()->id()
            );
        }

        $this->reset('photos');
        $this->emit('photoAdded', $this->motor->fullos);
        $this->motor->refresh();
    }

    /* ------------------------------ Otros métodos ------------------------------ */

    public function loadStatusModal(int $id_motor): void
    {
        $this->equipo    = Motor::find($id_motor);
        $this->newStatus = $this->equipo->status_id;
    }

    public function updateStatus(): void
    {
        $this->validateOnly('newStatus');

        $this->motor->update(['status_id' => $this->newStatus]);
    }

    public function removeDoc($id): void
    {
        $this->motor->documentos()->find($id)?->delete();
        $this->motor->refresh();
    }

    public function updatedFullGallery(): void
    {
        $this->dispatchBrowserEvent('init-swiper');
    }

    public function saveComment(): void
    {
        $this->validateOnly('comment');

        $titulo = match (Auth::user()->userType) {
            User::DEVELOPER      => 'Comentario de Gerencia',
            User::GERENCIA       => 'Comentario de Gerencia',
            User::ADMINISTRACION => 'Comentario de Administración',
            User::BODEGA         => 'Comentario de Bodega',
            User::TORNOS         => 'Comentario de Tornos',
            User::TECNICO        => 'Comentario de Técnico',
            User::AYUDANTES      => 'Comentario de Ayudantes',
            User::PRUEBAS        => 'Comentario de departamento de Pruebas',
            User::PILOTOS        => 'Comentario de Pilotos',
            User::VENDEDORES     => 'Comentario de Vendedores',
            User::JEFE           => 'Comentario de Jefe de Taller',
            User::PINTURA        => 'Comentario de Pintura',
        };

        $this->motor->bitacoras()->create([
            'titulo'      => $titulo,
            'descripcion' => $this->comment,
            'id_usuario'  => auth()->id(),
        ]);

        $this->reset('comment');
        $this->motor->refresh();
    }

    public function removePhoto($id): void
    {
        $foto = $this->motor->fotos()->find($id);
        if ($foto) {
            Storage::disk('public')->delete([$foto->foto, $foto->thumb]);
            $foto->delete();
            $this->motor->refresh();
        }
    }
}

