<?php

namespace App\Http\Livewire\Boards;

use Livewire\Component;

class BoardsNavigation extends Component
{
    public $boards;
    protected $listeners = ['boardStored' => 'render'];
    public function render()
    {
        $this->boards = auth()->user()->sharedBoards;
        return view('livewire.boards.boards-navigation');
    }
}
