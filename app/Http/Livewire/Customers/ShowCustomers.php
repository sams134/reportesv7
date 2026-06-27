<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Motor;
use App\Models\Status;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ShowCustomers extends Component
{
    use withPagination;
    protected $paginationTheme = 'bootstrap';
    public Cliente $cliente;
    public $sort = 'fullos', $direction = 'desc';
    public $equipo, $statuses, $newStatus;
    public $selectedContactoId;

    public $clientUsername;
    public $clientPassword;
    public $clientPasswordConfirmation;

    public $welcomeName;
    public $welcomeUsername;
    public $welcomePassword;
    public $welcomeUrl = 'http://45.188.128.210/';

    protected $listeners = ['render', 'deleteContact'];
    public function mount($cliente)
    {
        $this->cliente = Cliente::with([
            'info_cliente',
            'contactos.user',
        ])
            ->withCount('motors')
            ->findOrFail($cliente->id_cliente);

        $this->statuses = Status::all();
        $this->equipo = new Motor();
    }
    public function render()
    {
        $this->cliente = Cliente::with([
            'info_cliente',
            'contactos.user',
        ])
            ->withCount('motors')
            ->findOrFail($this->cliente->id_cliente);

        $motores = Motor::with([
            'cliente',
            'tecnicos',
            'trabajos',
            'bitacoras',
            'fotos.tipoFoto',
        ]);
        $motores = $motores->where('id_cliente', $this->cliente->id_cliente);
        $motores = $motores->where('year', 'like', '2M%');
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
        return view('livewire.customers.show-customers', [
            'motores' => $motores->withQueryString()
        ]);
    }
    public function deleteContact($id)
    {
        Contacto::find($id)->delete();
        $this->render();
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
    public function openCreateClientUser($contactoId)
    {
        $this->resetValidation();

        $contacto = Contacto::where('id', $contactoId)->firstOrFail();

        if ($contacto->user_id) {
            return;
        }

        if (! $contacto->email) {
            $this->addError('clientUser', 'Este contacto no tiene email. No se puede crear usuario.');

            return;
        }

        $this->selectedContactoId = $contacto->id;
        $this->clientUsername = $this->suggestClientUsername($contacto);
        $this->clientPassword = '';
        $this->clientPasswordConfirmation = '';

        $this->dispatchBrowserEvent('open-create-client-user-modal');
    }

    private function suggestClientUsername($contacto)
    {
        $base = $contacto->email
            ? Str::before($contacto->email, '@')
            : $contacto->contacto;

        $base = Str::of($base)
            ->lower()
            ->ascii()
            ->replace(' ', '.')
            ->replaceMatches('/[^a-z0-9._-]/', '')
            ->trim('.');

        if ($base == '') {
            $base = 'cliente';
        }

        $username = (string) $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }

    public function createClientUser()
    {
        $this->validate([
            'selectedContactoId' => ['required', 'integer', 'exists:contactos,id'],
            'clientUsername' => [
                'required',
                'string',
                'max:191',
                'regex:/^[A-Za-z0-9._-]+$/',
                'unique:users,username',
            ],
            'clientPassword' => ['required', 'string', 'min:6'],
            'clientPasswordConfirmation' => ['required', 'same:clientPassword'],
        ], [
            'clientUsername.regex' => 'El usuario solo puede contener letras, números, punto, guion y guion bajo.',
            'clientPassword.min' => 'La clave debe tener mínimo 6 caracteres.',
            'clientPasswordConfirmation.same' => 'La revisión de clave no coincide.',
        ]);

        try {
            DB::transaction(function () {
                $contacto = Contacto::lockForUpdate()->findOrFail($this->selectedContactoId);

                if ($contacto->user_id) {
                    throw ValidationException::withMessages([
                        'clientUser' => 'Este contacto ya tiene un usuario asignado.',
                    ]);
                }

                if (! $contacto->email) {
                    throw ValidationException::withMessages([
                        'clientUser' => 'Este contacto no tiene email.',
                    ]);
                }

                if (User::where('email', $contacto->email)->exists()) {
                    throw ValidationException::withMessages([
                        'clientUser' => 'Ya existe un usuario con este email.',
                    ]);
                }

                $user = new User();
                $user->username = $this->clientUsername;
                $user->name = $contacto->contacto;
                $user->email = $contacto->email;
                $user->password = Hash::make($this->clientPassword);
                $user->userType = User::CLIENTE;
                $user->activo = 1;
                $user->id_cliente = $contacto->id_cliente;
                $user->save();

                $contacto->user_id = $user->id;
                $contacto->save();

                $this->welcomeName = $user->name;
                $this->welcomeUsername = $user->username;
                $this->welcomePassword = $this->clientPassword;
            });

            $this->clientPassword = '';
            $this->clientPasswordConfirmation = '';

            $this->dispatchBrowserEvent('close-create-client-user-modal');
            $this->dispatchBrowserEvent('open-client-user-welcome-modal');

            $this->emitSelf('$refresh');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            report($e);

            $this->addError('clientUser', 'No se pudo crear el usuario del cliente.');
        }
    }
}
