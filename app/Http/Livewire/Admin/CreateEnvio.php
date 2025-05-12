<?php

namespace App\Http\Livewire\Admin;

use App\Models\Envio;
use App\Models\Motor;
use App\Models\Piloto;
use App\Models\Vehiculo;
use Livewire\Component;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as IMG;

class CreateEnvio extends Component
{
    use WithFileUploads;
    public $motor;
    public $fotoFinal;
    public $pilotosDB,$vehiculosDB;
    public $selectedPiloto=-1,$selectedVehiculo=-1;
    public $piloto,$tipo_vehiculo,$placa,$dpi;
    public $newPart,$observaciones;

    public $agregarCojinetes=true,$agregarRetenedores=true;
    public $partes = [];
    public $photo;


    protected $rules = [
        'piloto' => 'required',
        'dpi' => 'required',
        'tipo_vehiculo' => 'required',
        'placa' => 'required',
    ];
    public function mount(Motor $motor)
    {
        
        $this->motor = $motor;
        $this->pilotosDB = Piloto::orderBy('name', 'asc')->get();
        $this->vehiculosDB = Vehiculo::orderBy('name', 'asc')->get();
        if ($this->motor->envioFinal) {
            $this->piloto = $this->motor->envioFinal->nombre_piloto;
            $this->tipo_vehiculo = $this->motor->envioFinal->tipo_vehiculo;
            $this->placa = $this->motor->envioFinal->placa_vehiculo;
            $this->dpi = $this->motor->envioFinal->dpi_piloto;
            $this->observaciones = $this->motor->envioFinal->comentarios;
            $this->partes = $this->motor->envioFinal->enviosAdicionales->pluck('parte')->toArray();
            $this->agregarCojinetes = false;
            $this->agregarRetenedores = false; 
        }
        
    }
    public function render()
    {

        $this->fotoFinal = $this->motor->fotos->where('type', 100)->last();
        if (!$this->fotoFinal) {
            $this->fotoFinal = $this->motor->fotos->first();
        }
        if ($this->agregarCojinetes) 
            $this->partes[0] = 'Cojinetes en Mal Estado';
        if ($this->agregarRetenedores) 
            $this->partes[1] = 'Retenedores en Mal Estado';

        return view('livewire.admin.create-envio');
    }
    public function store()
    {
        $this->emit('closeCreateEnvio'); // enviado al JS de la pagina para cerrar el modal
        return redirect()->route('motores.downloadPdf', $this->motor)->with('openInNewTab', true);
    }
    public function updatedSelectedPiloto($piloto_id)
    {
        if ($piloto_id == 0) {
            $this->piloto = null;
            $this->dpi = null;
            $this->selectedPiloto = 0;
            return;
        }
        $driver = Piloto::find($piloto_id);
        $this->piloto = $driver->name;
        $this->dpi = $driver->dpi;
        $this->selectedPiloto = $piloto_id;
        
    }
    public function updatedSelectedVehiculo($vehiculo_id)
    {
        if ($vehiculo_id == 0) {
            $this->tipo_vehiculo = null;
            $this->placa = null;
            $this->selectedVehiculo = 0;
            return;
        }
        $vehicle = Vehiculo::find($vehiculo_id);
        $this->tipo_vehiculo = $vehicle->tipo;
        $this->placa = $vehicle->placa;
        $this->selectedVehiculo = $vehiculo_id;
    }
    public function updatedAgregarCojinetes()
    {
        if (!$this->agregarCojinetes) {
           $this->partes[0] = "";
        } else {
            $this->partes[0] = 'Cojinetes en Mal Estado';
        }
    }
    public function updatedAgregarRetenedores()
    {
        if (!$this->agregarRetenedores) {
           $this->partes[1] = "";
        } else {
            $this->partes[1] = 'Retenedores en Mal Estado';
        }
    }
    public function updatedPhoto()
    {
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
                'type' => 100,
                'user_id' => auth()->id(),
            ]);
            $this->emit('photoAdded', $this->motor->fullos);
            }
            
        
    }
    public function addPart()
    {
        $this->partes[] = ucfirst($this->newPart);
        $this->newPart = "";
    }
    public function removeParte($index)
    {
        unset($this->partes[$index]);
    }
    public function generatePDF()
    {
       
        $this->validate();
        $data = [
            'fecha'          => now(),
            'tipo_vehiculo'  => $this->tipo_vehiculo,
            'placa_vehiculo' => $this->placa,
            'nombre_piloto'  => $this->piloto,
            'dpi_piloto'     => $this->dpi,
            'tipo_envio'     => 1,
            'comentarios'    => $this->observaciones,
        ];
        
        // Si ya existe un envioFinal, lo actualizamos; de lo contrario, lo creamos.
        $envioFinal= new Envio();
        if ($this->motor->envioFinal) {
            $this->motor->envioFinal->update($data);
        } else {
            $this->motor->envioFinal()->create($data);
        }
        if ($this->motor->envioFinal->enviosAdicionales) {
            $this->motor->envioFinal->enviosAdicionales()->delete();
        }
        

        collect($this->partes)
            ->filter()
            ->each(function ($parte) {
            $this->motor->envioFinal->enviosAdicionales()->create(['parte' => $parte]);
            });
        return redirect()->route('admin.envioPDF', $this->motor)->with('openInNewTab', true);
    }
}
