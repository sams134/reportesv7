<?php

namespace App\Http\Livewire\Motors;

use App\Models\Board;
use Livewire\Component;

class CreateBoard extends Component
{
    public $name;
    protected $rules = [
        'name' => 'required|unique:boards,name'
    ];
    
    public function render()
    {
        return view('livewire.motors.create-board');
    }
    public function store()
    {
        $this->validate();
        $board = Board::create([
            'name' => $this->name,
            'owner_id' => auth()->id()
        ]);
        $board->sharedUsers()->attach(auth()->id());
        $this->emit('boardStored');
        $this->reset();
        
    }
}
