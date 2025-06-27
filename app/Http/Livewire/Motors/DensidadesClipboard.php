<?php

namespace App\Http\Livewire\Motors;

use Livewire\Component;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;




class DensidadesClipboard extends Component
{
    public $screenshot1 = null;
    public $screenshot2 = null;

    protected $listeners = ['screenshotPasted'];

    public function screenshotPasted($index, $dataUrl)
    {
        if ($index == 1) {
            $this->screenshot1 = $dataUrl;
        } elseif ($index == 2) {
            $this->screenshot2 = $dataUrl;
        }
    }
   public function savePdf(): void
{
    // 1️⃣ Recolectar capturas disponibles (base64)
    $captures = collect([
        $this->screenshot1,
        $this->screenshot2,
    ])->filter();

    if ($captures->isEmpty()) {
        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Sin capturas',
            'text'  => 'Pega al menos una imagen antes de guardar.',
            'icon'  => 'warning',
        ]);
        return;
    }

    // 2️⃣ Procesar imágenes y guardarlas como PNG temporales
    $tempPaths   = [];
    $publicPaths = [];

    foreach ($captures as $capture) {
        $img = Image::make($capture); // ← usando facade clásico

        // Redimensionar si es necesario
        if ($img->width() > 1200) {
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Guardar imagen temporal
        $fileName = 'densidad_' . uniqid() . '.png';
        $temp     = 'temp/' . $fileName;

        Storage::disk('public')->put($temp, (string) $img->encode('png'));

        $tempPaths[]   = $temp;
        $publicPaths[] = asset('storage/' . $temp);
    }

    // 3️⃣ Generar el PDF con Snappy
    $pdf = SnappyPdf::loadView('exports.densidades-pdf', [
                'images' => $publicPaths,
            ])
            ->setPaper('a4')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10);

    $pdfName = 'densidades_' . now()->format('Ymd_His') . '.pdf';
    $pdfPath = 'densidades/' . $pdfName;

    Storage::disk('public')->put($pdfPath, $pdf->output());

    // 4️⃣ Borrar imágenes temporales
    foreach ($tempPaths as $temp) {
        Storage::disk('public')->delete($temp);
    }

    // 5️⃣ Resetear y lanzar evento al frontend
    $this->reset(['screenshot1', 'screenshot2']);

    $this->dispatchBrowserEvent('pdfReady', asset('storage/' . $pdfPath));

    $this->dispatchBrowserEvent('swal:alert', [
        'title' => 'PDF creado',
        'text'  => 'El archivo se generó correctamente.',
        'icon'  => 'success',
    ]);
}
    public function render()
    {
        return view('livewire.motors.densidades-clipboard');
    }
}
