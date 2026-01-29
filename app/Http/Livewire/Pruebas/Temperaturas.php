<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use App\Models\Temperatura;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as IMG;

class Temperaturas extends Component
{
    use WithFileUploads;
    public $motor, $cliente;
    public $time = 0;
    public $timeFormatted = '00:00:00:00'; // Variable para el tiempo formateado
    public $temperatures = ['time' => [], 'carga' => [], 'opuesto' => [], 'estator' => []];
    public $estator_t, $carga_t, $opuesto_t;
    public $isRunning = false;
    public $photo;
    public $thermo1; // TemporaryUploadedFile
    public $thermo2;
    public $thermo3;
    public $manual_seconds;
    public $manualMode = false;
    public $temp_comment;


    protected $listeners = ['updateTime'];


    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
        $this->cliente = $this->motor->cliente;
    }
    public function updateTime($time)
    {
        $this->time = $time;
        $hours = floor($time / 3600000);
        $minutes = floor(($time % 3600000) / 60000);
        $seconds = floor(($time % 60000) / 1000);
        $miliseconds = $time % 1000;
        $this->timeFormatted = sprintf('%02d:%02d:%02d:%02d', $hours, $minutes, $seconds, $miliseconds / 10);
    }

    public function registerTemp()
    {
        $this->validate([
            'carga_t' => 'required|numeric',
            'opuesto_t' => 'required|numeric',
            'estator_t' => 'required|numeric',
        ]);
        Temperatura::create([
            'id_motor' => $this->motor->id_motor,
            'carga' => $this->carga_t,
            'opuesto' => $this->opuesto_t,
            'estator' => $this->estator_t,
            'time' => $this->timeFormatted
        ]);
        $this->reset(['carga_t', 'opuesto_t', 'estator_t']);
        $this->emit('updateGraph');
    }
    public function start()
    {
        $this->isRunning = true;
    }
    public function stop()
    {
        $this->isRunning = false;
    }
    public function render()
    {
        $thermo71 = $this->motor->fotos()->where('type', 71)->latest()->first();
        $thermo72 = $this->motor->fotos()->where('type', 72)->latest()->first();
        $thermo73 = $this->motor->fotos()->where('type', 73)->latest()->first();
        $this->temp_comment = $this->motor->temperaturas_comentario;


        return view('livewire.pruebas.temperaturas', compact('thermo71', 'thermo72', 'thermo73'));
    }
    public function deleteTest()
    {
        Temperatura::where('id_motor', $this->motor->id_motor)->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->isRunning = false;
        $this->emit('updateGraph');
    }
    public function deleteTemp($id)
    {
        $temp = Temperatura::find($id);
        $temp->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->emit('updateGraph');
    }
    public function getTemperatures($id_motor)
    {
        $temperatures = Temperatura::where('id_motor', $id_motor)->get();
        foreach ($temperatures as $temperature) {
            $this->temperatures['time'][] = $temperature->time;
            $this->temperatures['carga'][] = $temperature->carga;
            $this->temperatures['opuesto'][] = $temperature->opuesto;
            $this->temperatures['estator'][] = $temperature->estator;
        }
        return response()->json($this->temperatures);
    }
    public function saveThermography(): void
    {
        $this->validate([
            'thermo1' => 'nullable|image|max:10240', // 10MB
            'thermo2' => 'nullable|image|max:10240',
            'thermo3' => 'nullable|image|max:10240',
        ]);

        if (!$this->thermo1 && !$this->thermo2 && !$this->thermo3) {
            $this->dispatchBrowserEvent('swal:alert', [
                'title' => 'Sin imágenes',
                'text'  => 'Pega al menos una imagen termográfica.',
                'icon'  => 'warning',
            ]);
            return;
        }

        // Folder típico de fotos del motor (ajústalo si tu sistema usa otro)
        $folderPath = '/uploads/' . "{$this->motor->year}-{$this->motor->os}" . '/Fotos';
        Storage::disk('public')->makeDirectory($folderPath);

        $map = [
            'thermo1' => 71, // tipos sugeridos
            'thermo2' => 72,
            'thermo3' => 73,
        ];

        foreach ($map as $key => $type) {
            if ($this->{$key}) {
                $name = "termografia_{$type}_" . now()->format('Ymd_His') . '.jpg';
                $path = $this->{$key}->storeAs($folderPath, $name, 'public');

                // Guarda en tu tabla de fotos (ajusta nombres de columnas si difieren)
                $this->motor->fotos()->create([
                    'foto'    => '/' . ltrim($path, '/'),
                    'type'    => $type,
                    'user_id' => auth()->id(),
                    'titulo' => 'Termografía (Temperaturas)',
                ]);
            }
        }

        $this->reset(['thermo1', 'thermo2', 'thermo3']);

        // refresca show/parent
        $this->emitUp('refreshMotor');

        // opcional: cerrar modal si lo usas
        $this->dispatchBrowserEvent('closeThermoModal');

        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Guardado',
            'text'  => 'Imágenes termográficas guardadas en Fotos.',
            'icon'  => 'success',
        ]);
    }
    public function deleteThermoByType(int $type): void
    {
        $photo = $this->motor->fotos()->where('type', $type)->latest()->first();

        if (!$photo) return;

        // borrar archivo físico
        if ($photo->foto) {
            Storage::disk('public')->delete(ltrim($photo->foto, '/'));
        }

        $photo->delete();

        // refrescar motor para que render re-traiga los slots vacíos
        $this->motor = Motor::find($this->motor->id_motor);

        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Eliminado',
            'text'  => 'La termografía fue eliminada.',
            'icon'  => 'success',
        ]);
    }
    public function toggleManualMode()
    {
        $this->manualMode = !$this->manualMode;
    }
    public function registerTempManual()
    {
        $this->validate([
            'manual_seconds' => 'required|numeric|min:0',
            'carga_t'        => 'required|numeric',
            'opuesto_t'      => 'required|numeric',
            'estator_t'      => 'required|numeric',
        ]);

        $seconds = (int) $this->manual_seconds;

        // Formato igual que tu sistema: HH:MM:SS:00
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $secs = $seconds % 60;
        $timeFormatted = sprintf('%02d:%02d:%02d:%02d', $hours, $minutes, $secs, 0);

        Temperatura::create([
            'id_motor' => $this->motor->id_motor,
            'carga'    => $this->carga_t,
            'opuesto'  => $this->opuesto_t,
            'estator'  => $this->estator_t,
            'time'     => $timeFormatted,
        ]);
        $this->motor = Motor::with('temps')->find($this->motor->id_motor);

        $this->reset(['manual_seconds', 'carga_t', 'opuesto_t', 'estator_t']);
        $this->emit('updateGraph');
    }
    public function saveTempComment()
    {
        $this->validate([
            'temp_comment' => 'nullable|string|max:2000',
        ]);

        $this->motor->temperaturas_comentario = $this->temp_comment;
        $this->motor->save();

        $this->dispatchBrowserEvent('swal:alert', [
            'title' => 'Guardado',
            'text'  => 'Comentario de temperaturas guardado.',
            'icon'  => 'success',
        ]);
    }
}
