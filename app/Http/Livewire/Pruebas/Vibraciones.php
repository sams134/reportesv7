<?php

namespace App\Http\Livewire\Pruebas;
use App\Models\Motor;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class Vibraciones extends Component
{
    use WithFileUploads;

    public Motor $motor;
    public $doc; // TemporaryUploadedFile

    public function mount(Motor $motor)
    {
        $this->motor = $motor;
    }

    public function updatedDoc()
    {
        $this->validate([
            'doc' => 'required|file|mimes:pdf|max:20480',
        ]);

        $folderPath = '/uploads/' . "{$this->motor->year}-{$this->motor->os}" . '/Documentos';
        Storage::disk('public')->makeDirectory($folderPath);

        $name = 'vibraciones_' . now()->format('Ymd_His') . '.pdf';
        $path = $this->doc->storeAs($folderPath, $name, 'public');

        $this->motor->documentos()->create([
            'titulo'    => $name,
            'documento' => '/' . ltrim($path, '/'),
            'id_user'   => auth()->id(),
            'seccion'   => 'vibraciones',
        ]);

        $this->reset('doc');
        $this->emitUp('refreshMotor');
    }

    public function deleteDoc($docId)
    {
        $doc = $this->motor->documentos()
            ->where('id', $docId)
            ->where('seccion', 'vibraciones')
            ->firstOrFail();

        if ($doc->documento) {
            $relative = ltrim($doc->documento, '/');
            Storage::disk('public')->delete($relative);
        }

        $doc->delete();

        $this->emitUp('refreshMotor');
        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Eliminado',
            'text'  => 'El PDF de vibraciones fue eliminado.',
            'icon'  => 'success',
        ]);
    }

    public function render()
    {
        $docsVibraciones = $this->motor->documentos()
            ->where('seccion', 'vibraciones')
            ->latest()
            ->get();

        return view('livewire.pruebas.vibraciones', compact('docsVibraciones'));
    }
}
