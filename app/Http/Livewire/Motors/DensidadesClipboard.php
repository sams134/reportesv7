<?php

namespace App\Http\Livewire\Motors;

use Livewire\Component;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;
use App\Models\Motor;




class DensidadesClipboard extends Component
{
    use WithFileUploads;



    public $image1; // TemporaryUploadedFile
    public $image2; // TemporaryUploadedFile


    public Motor $motor;

    public function mount(Motor $motor)
    {
        $this->motor = $motor;
    }


    

    public function savePdf(): void
    {
        // Validación (ajusta tamaños si quieres)
        $this->validate([
            'image1' => 'nullable|image|max:5120', // 5MB
            'image2' => 'nullable|image|max:5120',
        ]);

        if (!$this->image1 && !$this->image2) {
            $this->dispatchBrowserEvent('swal:alert', [
                'title' => 'Sin capturas',
                'text'  => 'Pega al menos una imagen antes de guardar.',
                'icon'  => 'warning',
            ]);
            return;
        }

        // Guardar imágenes temporalmente en public (para wkhtmltopdf)
        $stored = [];
        foreach (['image1', 'image2'] as $key) {
            if ($this->{$key}) {
                $path = $this->{$key}->store('temp/densidades', 'public');
                $stored[] = [
                    'relative' => $path,
                    'public' => public_path('storage/' . $path), // path real en disco
                ];
            }
        }

        // Guardar PDF en el folder del motor (mismo patrón que tus Documentos)
        $folderPath = '/uploads/' . "{$this->motor->year}-{$this->motor->os}" . '/Documentos';
        Storage::disk('public')->makeDirectory($folderPath);

        $pdfName = 'densidades_' . "{$this->motor->year}-{$this->motor->os}" . '.pdf';
        $pdfFullPath = $folderPath . '/' . $pdfName;

        $pdf = SnappyPdf::loadView('pdfs.densidades-pdf', [
            'motor'   => $this->motor,
            'tecnico' => auth()->user()->name ?? '',
            'images'  => collect($stored)->pluck('public')->values()->all(), // ABSOLUTAS
        ])
            ->setPaper('a4')
            ->setOption('enable-local-file-access', true)  // CLAVE
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10);

        // 1) Guardar archivo PDF
        Storage::disk('public')->put($pdfFullPath, $pdf->output());

        // 2) Crear registro en documentos para que aparezca el card en "Documentos cargados"
        //    (usa los mismos campos que usa tu subida normal)
        $this->motor->documentos()->create([
            'titulo'    => $pdfName,       // o 'Densidades' si prefieres
            'documento' => $pdfFullPath,   // IMPORTANTE: relativo al disk public, sin 'storage/'
            'id_user'   => auth()->id(),
        ]);

        // 3) Borrar temporales
        foreach ($stored as $img) {
            Storage::disk('public')->delete($img['relative']);
        }

        // 4) Reset
        $this->reset(['image1', 'image2']);


        // 5) Forzar refresh del padre (ShowMotor) para que se muestre el card sin recargar la página
        $this->emitUp('refreshMotor');

        // 6) Cerrar modal
        $this->dispatchBrowserEvent('closeDensidadesModal');

        // 6) Abrir el PDF recién creado
        $this->dispatchBrowserEvent('pdfReady', asset('storage' . $pdfFullPath));

        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'PDF creado',
            'text'  => 'El archivo se generó y se guardó en Documentos.',
            'icon'  => 'success',
        ]);
    }



    public function render()
    {
        return view('livewire.motors.densidades-clipboard');
    }
}
