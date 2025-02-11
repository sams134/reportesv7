<?php

namespace App\Http\Livewire\Metalizados;

use App\Models\Cliente;
use App\Models\Motor;
use App\Models\MotorMetalizado;
use Livewire\Component;
use App\Models\Config;
use Intervention\Image\Facades\Image as Img;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class MetalizadosCreate extends Component
{
    use WithFileUploads;

   
    public $clientes = [];
    public $search = '';
    public $motorSelected;
    public $cliente_id;
    public $year = '',$os ='';
    public $largo, $diametro, $profundidad=2;
    public $photo;


    protected $rules = [
        'photo' => 'nullable|image|max:4096', // Permite imagen o nulo, máximo 2MB
        'largo' => 'required|numeric|min:0.01|max:999.99',
        'diametro' => 'required|numeric|min:0.01|max:999.99',
        'profundidad' => 'required',
        'cliente_id' => 'required|exists:clientes,id_cliente',
        'motorSelected' => 'required|exists:motors,id_motor',
        'year' => 'required',
        'os' => 'required'

    ];
    
    public function mount()
    {
       
        
    }

    public function updatedImage()
    {
        $this->validateOnly('image');
    }
    public function render()
    {
        $this->clientes = Cliente::orderBy('cliente', 'asc')->get();
        $this->year = Config::find(1)->year;
        $this->os = MotorMetalizado::where('year', "MET" . $this->year)->max('os');
        $this->os = $this->os + 1;
        $this->os = str_pad("" . $this->os, 4, "0", STR_PAD_LEFT);
        //$motors = Motor::orderBy('year', 'desc')->orderBy('os', 'desc')->paginate(8);
        $motores = Motor::with([
            'cliente',
           
        ]);

        $motores = $motores->where('year', 'like', '2M%');

        
        // Si el usuario es técnico, filtrar por motores asignados al técnico
        
     

        // Si hay una búsqueda
        $search = $this->search;
        if ($search) {
            // Si la búsqueda contiene un guion (ej. "2M23-056")
            if (strpos($search, '-') !== false) {
                $parts = explode('-', $search, 2);
                if (count($parts) == 2) {
                    $yearSearch = trim($parts[0]); // Por ejemplo "2M23"
                    $osSearch = trim($parts[1]);   // Por ejemplo "56"
                    // Asegurarse de que OS tenga 4 dígitos
                    $osSearch = str_pad($osSearch, 4, '0', STR_PAD_LEFT);
                    $motores = $motores->where('year','like', "%$yearSearch")
                        ->where('os', 'like', "$osSearch%");
                }
            }
            // Si empieza con un número (buscar por OS)
            elseif (is_numeric($search[0])) {
                $os = str_pad($search, 4, '0', STR_PAD_LEFT);
                $motores = $motores->where('os', 'like', "$os%");
            }
            // Si empieza con una letra (buscar en cliente, contacto o técnico)
            elseif (ctype_alpha($search[0])) {
                $motores = $motores->where(function ($query) use ($search) {
                    $query->whereHas('cliente', function ($query) use ($search) {
                        $query->where('cliente', 'like', "%$search%");
                    })
                        ->orWhereHas('cliente.contactos', function ($query) use ($search) {
                            $query->where('contacto', 'like', "%$search%");
                        })
                        ->orWhereHas('tecnicos', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                });
            }
        }
        $motores = $motores
                ->orderBy('year', 'desc')
                ->orderBy('os', 'desc')
                ->paginate(8);

        return view('livewire.metalizados.metalizados-create')->with([
            'motors' => $motores,
        ]);
    }
    public function selectMotor($motorId)
    {
        $this->motorSelected = $motorId;
        $motor = Motor::find($motorId);
        $this->search = $motor->year . '-' . $motor->os;    
        $this->cliente_id = $motor->cliente->id_cliente;

        // Opcional: emitir un evento o hacer alguna acción adicional
        // $this->emit('motorSelected', $motorId);
    }
    public function store(){
        $this->validate();
        $motorMetalizado = MotorMetalizado::create([
            'year' => "MET" . $this->year,
            'os' => $this->os,
            'id_cliente' => $this->cliente_id,
            'id_motor' => $this->motorSelected,
            'largo' => $this->largo,
            'diametro' => $this->diametro,
            'profundidad' => $this->profundidad,
        ]);
        $folderPath = '/uploads/' . "MET" . $this->year . '-' . $this->os . '/metalizados';
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

        $motorMetalizado->images()->create([
            'image' => $imagePath,
            'comentario' => 'Pieza que necesita ser metalizada',
            'user_id' => auth()->id(),
        ]);

        $this->emit('closeNewMetalizado');

        $this->reset();
    }
}
