<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShareBoard extends Component
{
    public Board $board;
    public $users;
    public $tecnicoSelected = [];

    public function mount(Board $board): void
    {
        // 1️⃣ Verificar que el usuario autenticado sea el propietario
      //  abort_if(Auth::id() !== $board->owner_id, 403, 'Solo el propietario puede compartir este tablero.');

        $this->board = $board;
        // 2️⃣ Cargar usuarios excepto el actual y los inactivos
        $this->users = User::where('id', '!=', Auth::id())
            ->where('activo', 1)
            ->orderBy('name')
            ->get();

        // 3️⃣ Pre‑marcar los que ya están compartidos
        $this->tecnicoSelected = [];
        foreach ($this->board->sharedUsers as $user) {
            $this->tecnicoSelected[$user->id] = true;
        }
    }

    public function saveShared(): void
    {

        // Filtrar los IDs cuyo valor sea true
        $selectedIds = collect($this->tecnicoSelected)
            ->filter(fn($checked) => $checked)
            ->keys()
            ->map(fn($id) => (int) $id)
            ->all();

        // 4️⃣ Sincronizar relación many‑to‑many
        $this->board->sharedUsers()->sync($selectedIds);

        $userNames = \App\Models\User::whereIn('id', $selectedIds)->pluck('name')->all();

        // Emitir evento al frontend
        $this->dispatchBrowserEvent('close-compartir-modal', [
            'id' => $this->board->id,
            'board' => $this->board->name,
            'users' => $userNames,
        ]);
    }
    public function render()
    {
        return view('livewire.boards.share-board');
    }
}
