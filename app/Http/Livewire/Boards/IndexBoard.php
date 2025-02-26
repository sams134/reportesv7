<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Livewire\Component;

class IndexBoard extends Component
{
    public $board;
    public function mount(Board $board)
    {
        $this->board = $board;
    }
    public function render()
    {
        return view('livewire.boards.index-board');
    }
}
