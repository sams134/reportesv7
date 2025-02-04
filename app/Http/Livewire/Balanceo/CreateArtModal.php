<?php

namespace App\Http\Livewire\Balanceo;

use App\Models\Balanceo;
use App\Models\BalanceoArt;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class CreateArtModal extends Component
{
    use WithFileUploads;

    public $file;
    protected $rules = [
        'file' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Limita a 2MB
    ];

    public function render()
    {
        return view('livewire.balanceo.create-art-modal');
    }

    public function store()
    {
        $this->validate();

        if (!$this->file) {
            dd("No se recibió el archivo.");
        }
        // Procesar imagen con Intervention Image
        $image = Image::make($this->file->getRealPath());
        $image->resize(430, 300, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Generar nombre único para la imagen
        $filename = 'balanceos_arts/' . uniqid() . '.' . $this->file->getClientOriginalExtension();

        // Guardar la imagen en el disco 'public'
        Storage::disk('public')->put($filename, (string) $image->encode());

        // Guardar la imagen en la base de datos
        BalanceoArt::create([
            'image' => 'storage/'.$filename,
        ]);

        // Emitir evento y resetear el input
        $this->emit('artCreated');
        $this->reset();
       
    }
}
