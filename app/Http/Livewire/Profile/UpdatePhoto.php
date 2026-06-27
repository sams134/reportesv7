<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;
use Intervention\Image\Facades\Image as IMG;

class UpdatePhoto extends Component
{
    use WithFileUploads;

    public $photo;
    public $name;
    public $email;
    public $phone;
    public $direccion;
    public $avatarUrl;
    public $avatarInitials;
    public $hasProfilePhoto = false;
    public $photoMessage;

    public $roleName;
    public $roleTools = [];

    public function mount()
    {
        $user = User::with('usuario')->findOrFail(auth()->id());

        $this->name = $user->name;
        $this->email = $user->email;

        $this->phone = optional($user->usuario)->telefono;
        $this->direccion = optional($user->usuario)->domicilio;

        $this->roleName = $user->role_name;
        $this->roleTools = $user->role_tools;

        $this->loadProfileAvatar($user);
    }

    public function render()
    {
        return view('livewire.profile.update-photo');
    }

    public function updatedPhoto()
    {
        $this->resetErrorBag('photo');
        $this->photoMessage = null;

        $this->validate([
            'photo' => 'nullable|image|max:10240',
        ], [
            'photo.image' => 'El archivo seleccionado debe ser una imagen.',
            'photo.max' => 'La imagen no debe pesar más de 10 MB.',
        ]);

        try {
            $user = User::findOrFail(auth()->id());

            $this->storeProfilePhoto($user);

            $user->save();

            $this->loadProfileAvatar($user);

            $this->photo = null;
            $this->photoMessage = 'Fotografía actualizada correctamente.';

            $this->emit('userUpdated');
        } catch (\Exception $e) {
            report($e);

            $this->photo = null;

            $this->addError('photo', 'No se pudo actualizar la fotografía. Error: ' . $e->getMessage());
        }
    }
    private function storeProfilePhoto(User $user)
    {
        if (! $this->photo) {
            return;
        }

        $folderPath = 'uploads/empleados';

        $image = IMG::make($this->photo->getRealPath());

        try {
            $orientation = $image->exif('Orientation');

            if ($orientation) {
                switch ($orientation) {
                    case 3:
                        $image->rotate(180);
                        break;

                    case 6:
                        $image->rotate(-90);
                        break;

                    case 8:
                        $image->rotate(90);
                        break;
                }
            }
        } catch (\Exception $e) {
            report($e);
        }

        $image->resize(1024, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $uniqueName = uniqid('img_', true) . '.' . $this->photo->getClientOriginalExtension();

        $imagePath = $folderPath . '/' . $uniqueName;

        Storage::disk('public')->put($imagePath, (string) $image->encode());

        if ($user->foto && Storage::disk('public')->exists(ltrim($user->foto, '/'))) {
            Storage::disk('public')->delete(ltrim($user->foto, '/'));
        }

        $user->foto = $imagePath;
    }
    public function updateProfile()
    {
        $this->validate([
            'photo' => 'nullable|image|max:10240',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:191',
            'direccion' => 'nullable|string|max:191',
        ]);

        DB::beginTransaction();

        try {
            $user = User::with('usuario')->findOrFail(auth()->id());

            $user->name = $this->name;
            $user->email = $this->email;

            $this->storeProfilePhoto($user);

            $user->save();
            $this->loadProfileAvatar($user);

            $usuario = $user->usuario;

            if (! $usuario) {
                $usuario = new Usuario();
                $usuario->id_user = $user->id;

                /*
                 * Estos campos son NOT NULL en tu tabla usuarios.
                 * Los llenamos con valores mínimos para evitar error SQL
                 * si el registro todavía no existe.
                 */
                $usuario->nombre = $user->name;
                $usuario->apellido = '';
            }

            $usuario->telefono = $this->phone;
            $usuario->domicilio = $this->direccion;
            $usuario->save();

            DB::commit();

            $this->photo = null;

            $this->emit('userUpdated');

            session()->flash('message', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            report($e);

            $this->addError('general', 'No se pudo actualizar el perfil. Error: ' . $e->getMessage());
        }
    }
    private function loadProfileAvatar(User $user)
    {
        $foto = $user->foto ? ltrim($user->foto, '/') : null;

        if ($foto && Storage::disk('public')->exists($foto)) {
            $this->hasProfilePhoto = true;
            $this->avatarUrl = asset('storage/' . $foto);
            $this->avatarInitials = null;

            return;
        }

        $this->hasProfilePhoto = false;
        $this->avatarUrl = null;
        $this->avatarInitials = $this->makeInitials($user->name ?: $user->username ?: $user->email);
    }

    private function makeInitials($name)
    {
        $name = trim((string) $name);

        if ($name === '') {
            return 'U';
        }

        $parts = preg_split('/\s+/', $name);

        if (count($parts) === 1) {
            return mb_strtoupper(mb_substr($parts[0], 0, 2));
        }

        return mb_strtoupper(
            mb_substr($parts[0], 0, 1) .
                mb_substr($parts[count($parts) - 1], 0, 1)
        );
    }
}
