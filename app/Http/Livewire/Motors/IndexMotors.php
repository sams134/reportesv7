<?php

namespace App\Http\Livewire\Motors;

use App\Models\Motor;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image as IMG;
use Livewire\WithFileUploads;

class IndexMotors extends Component
{
    use withPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $equipo, $statuses, $newStatus;
    public $sort = 'fullos', $direction = 'desc';
    public $boards, $photo;
    public $selectedMotors = [];
    public $cards = true, $ver = "Todos";
    public $camera_id_motor;
    public $s_marca, $s_modelo, $s_serie, $s_rpm, $s_potencia, $s_volts, $s_amps, $s_frame, $s_hac, $s_pot_mayor, $s_pot_menor;



    protected $listeners = ['removeMotor', 'render', 'boardStored' => 'render', 'forceStatusChange', 'status-changed' => 'statusChanged', 'cameraLoaded'];
    protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => 'fullos'],
        'direction' => ['except' => 'desc'],
    ];
    public function mount($search = '')
    {
        $this->search = $search;
        $this->equipo = new Motor();
        $this->statuses = Status::all();
        if (User::find(Auth::id())->config)
            $this->cards = User::find(Auth::id())->config->view_cards == 1 ? true : false;
        else
            $this->cards = false;
    }
    public function render()
    {
        $user = auth()->user();
        $this->boards = $user->boards;
        // Iniciar la consulta con relaciones
        $motores = Motor::with([
            'cliente',         // Relación con clientes
            'tecnicos',        // Relación con técnicos
            'trabajos',        // Relación con trabajos
            'bitacoras',       // Relación con bitácoras
            'fotos.tipoFoto',  // Relación con fotos y sus tipos
        ]);

        // Filtrar siempre por year que empiece con "2M"
        $motores = $motores->where('year', 'like', '2M%');
        switch ($this->ver) {
            case 'Todos':
                break;
            case 'Sin asignar':
               // $motores = $motores->whereDoesntHave('tecnicos'); // Filtrar motores sin técnicos asignados
                 $motores = $motores->whereIn('status_id', [-1]);
                break;
            case 'Sin autorizar':
                $motores = $motores->whereIn('status_id', [0, 1, 2]);
                break;
            case 'Trabajando':
                $motores = $motores->whereIn('status_id', [3, 4, 5, 6, 7, 8]);
                break;
            case 'Finalizados en Taller':
                $motores = $motores->where('status_id', 9);
                break;
            case 'Entregados':
                $motores = $motores->whereIn('status_id', [11, 12, 13, 14, 15]);
                break;
            case 'Cancelados':
                $motores = $motores->where('status_id', 5);
                break;
        }

        // Si el usuario es técnico, filtrar por motores asignados al técnico
        if ($user->userType === User::TECNICO) {
            $motores = $motores->whereHas('tecnicos', function ($query) use ($user) {
                $query->where('id_user', $user->id); // Solo motores asignados al técnico
            });
        }

        // Procesar la búsqueda si existe
        if ($this->search !== '') {
            if (strpos($this->search, '-') !== false) {
                $parts = explode('-', $this->search, 2);
                if (count($parts) == 2) {
                    $yearSearch = trim($parts[0]);
                    $osSearch = str_pad(trim($parts[1]), 4, '0', STR_PAD_LEFT);
                    $motores = $motores->where('year', 'like', "%$yearSearch")
                        ->where('os', 'like', "$osSearch%");
                }
            } elseif (is_numeric($this->search[0])) {
                $os = str_pad($this->search, 4, '0', STR_PAD_LEFT);
                $motores = $motores->where('os', 'like', "$os%");
            } elseif (ctype_alpha($this->search[0])) {
                $motores = $motores->where(function ($query) {
                    $query->whereHas('cliente', function ($q) {
                        $q->where('cliente', 'like', "%{$this->search}%");
                    })
                        ->orWhereHas('cliente.contactos', function ($q) {
                            $q->where('contacto', 'like', "%{$this->search}%");
                        })
                        ->orWhereHas('tecnicos', function ($q) {
                            $q->where('name', 'like', "%{$this->search}%");
                        });
                });
            }
        }
        if ($this->s_marca) {
            $motores = $motores->where('marca', 'like', "%{$this->s_marca}%");
        }
        if ($this->s_modelo) {
            $motores = $motores->where('modelo', 'like', "%{$this->s_modelo}%");
        }
        if ($this->s_serie) {
            $motores = $motores->where('serie', 'like', "%{$this->s_serie}%");
        }
        if ($this->s_rpm) {
            $motores = $motores->where('rpm', 'like', "%{$this->s_rpm}%");
        }
        if ($this->s_potencia) {
            $motores = $motores->where('hp', 'like', "%{$this->s_potencia}%");
        }
        if ($this->s_volts) {
            $motores = $motores->where('volts', 'like', "%{$this->s_volts}%");
        }
        if ($this->s_amps) {
            $motores = $motores->where('amps', 'like', "%{$this->s_amps}%");
        }
        if ($this->s_frame) {
            $motores = $motores->where('frame', 'like', "%{$this->s_frame}%");
        }
        if ($this->s_hac) {
            $motores = $motores->whereHas('infoMotor', function ($q) {
                $q->where('nombre_equipo', 'like', "%{$this->s_hac}%");
            });
        }
        if ($this->s_pot_mayor) {
            $motores = $motores->whereRaw(
                'CAST(hp AS DECIMAL(10,2)) >= ?',
                [$this->s_pot_mayor]
            );
        }

        if ($this->s_pot_menor) {
            $motores = $motores->whereRaw(
                'CAST(hp AS DECIMAL(10,2)) <= ?',
                [$this->s_pot_menor]
            );
        }

        if ($this->cards) {

            $motores = $motores->orderBy('year', 'desc')
                ->orderBy('os', 'desc')
                ->paginate(30);
        } else {
            // Ordenar y paginar según la propiedad $sort
            if ($this->sort === "fullos") {
                $motores = $motores->orderBy('year', $this->direction)
                    ->orderBy('os', $this->direction)
                    ->paginate(100);
            } elseif ($this->sort === 'hp') {
                $motores = $motores->orderByRaw("CAST(hp AS UNSIGNED) {$this->direction}")
                    ->paginate(100);
            } elseif ($this->sort === 'rpm') {
                $motores = $motores->orderByRaw("CAST(rpm AS UNSIGNED) {$this->direction}")
                    ->paginate(100);
            } else {
                $motores = $motores->orderBy($this->sort, $this->direction)
                    ->paginate(100);
            }
        }


        return view('livewire.motors.index-motors', [
            'motores' => $motores->withQueryString()
        ]);
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

        $this->equipo->status_id = $this->newStatus;
        $this->equipo->save();
    }
    public function removeMotor($id)
    {
        $motor = Motor::find($id);
        $motor->delete();
    }

    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }
    public function updatedSearch()
    {

        $this->sort = 'fullos';
        $this->direction = 'desc';
        $this->resetPage();
    }
    public function addTecnico($id)
    {
        $motor = Motor::find($id);
        $this->emit('showAsignacionesModalP1', $motor);
    }
    public function addToBoard($boardId)
    {
        $cant = 0;
        foreach ($this->selectedMotors as $motorId) {
            // Verificar si ya existe un pin para este board, motor y tipo
            $exists = \App\Models\Pin::where('board_id', $boardId)
                ->where('pinable_id', $motorId)
                ->where('pinable_type', 'App\\Models\\Motor')
                ->exists();

            if (!$exists) {
                \App\Models\Pin::create([
                    'user_id'      => auth()->id(),
                    'board_id'     => $boardId,
                    'pinable_id'   => $motorId,
                    'pinable_type' => 'App\\Models\\Motor',
                ]);
                $cant++;
            }
        }
        $this->selectedMotors = [];
        $board = \App\Models\Board::find($boardId);
        $this->emit('boardUpdated', $board->name, $cant);
    }
    public function toggleView()
    {
        $this->cards = !$this->cards;
        $user = User::find(Auth::id());
        if ($user->config) {
            $user->config->view_cards = $this->cards ? 1 : 0;
            $user->config->save();
        } else {
            $user->config()->create(['view_cards' => $this->cards ? 1 : 0]);
        }
    }
    public function forceStatusChange()
    {

        if (count($this->selectedMotors) === 0) {
            $this->emit('errorNoMotorsSelected');
            $this->skipRender();
        } else {

            $this->emitTo('motors.change-status-batch', 'openStatusModal', $this->selectedMotors);
            $this->skipRender();
        }
    }
    public function statusChanged()
    {
        $this->selectedMotors = [];
    }
    public function cameraLoaded($id_motor)
    {

        $this->camera_id_motor = $id_motor;
    }
    public function updatedPhoto()
    {



        try {
            $this->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $motor = Motor::find($this->camera_id_motor);
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

                $folderPath = '/uploads/' . "2M" . $motor->year . '-' . $motor->os . '/Fotos/Proceso';
                // Definir la ruta de la imagen
                $imagePath = $folderPath . '/' . $uniqueName;

                Storage::disk('public')->put($imagePath, (string) $image->encode());

                $foto = $motor->fotos()->create([
                    'titulo' => $uniqueName,
                    'foto' => $folderPath . '/' . $uniqueName,
                    'thumb' => $folderPath . '/' . $uniqueName,
                    'type' => 2,
                    'user_id' => auth()->id(),
                ]);
                $this->emit('photoAdded', $motor->fullos);
            }
            $this->photo = null;
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
        }
    }
}
