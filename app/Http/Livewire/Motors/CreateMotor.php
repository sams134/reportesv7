<?php

namespace App\Http\Livewire\Motors;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Contacto;
use App\Models\Motor;
use App\Models\Tipo_equipo;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMotor extends Component
{
    use WithFileUploads;
    public $clientesList,$customer="",$contactList=array(),$equipmentTypes,$year,$os,$inDate,$emailTo=[],$preAutorizado=false;
    public $inventory;
    public $photoInventory = [];
    public $nameplates = [];
    public $photosMotor = ['','','',''];
    public $step=0;
    

    public $listeners = ['next','prev','newCustomerAdded','render'];
    protected $rules = [
        'inventory.*.name' => '',
        'inventory.*.valor' => 'required',
        'photoInventory.*' => 'image|max:2048', // 2MB Max
        'nameplates.*' => 'image|max:2048', // 2MB Max
        'photosMotor.*' => 'image|max:2048|required', // 2MB Max
       
    ];


    public function mount(){
        $this->year = Config::find(1)->year;
        $this->os = Motor::where('year',"2M".$this->year)->max('os');
        $this->os = $this->os+1;
        $this->os = str_pad("".$this->os,4,"0",STR_PAD_LEFT);
        $this->inDate = Carbon::now()->format('d-m-Y');
        $this->equipmentTypes = Tipo_equipo::all();
        $this->inventory = collect();
        $this->addInventoryParts();
    }
    public function render()
    {
    
        $this->clientesList = Cliente::orderBy('cliente','asc')->get();
        if ($this->customer != "")
            $this->contactList = Contacto::where('id_cliente',$this->customer)->get();
        return view('livewire.motors.create-motor');
    }
    public function fillContacts()
    {
        $this->emailTo = [];
        $this->render();
    }
    public function addInventoryParts()
    {
        $this->inventory->push(['name' => 'Acople o polea','valor'=>'']);
        $this->inventory->push(['name' => 'Caja de Conexiones','valor'=>'']);
        $this->inventory->push(['name' => 'Tapa caja de conexiones','valor'=>'']);
        $this->inventory->push(['name' => 'Difusor','valor'=>'']);
        $this->inventory->push(['name' => 'Ventilador','valor'=>'']);
        $this->inventory->push(['name' => 'Bornera','valor'=>'']);
        $this->inventory->push(['name' => 'Cuña','valor'=>'']);
        $this->inventory->push(['name' => 'Graseras','valor'=>'']);
        $this->inventory->push(['name' => 'Cancamo','valor'=>'']);
        $this->inventory->push(['name' => 'Placa de Datos','valor'=>'']);
        $this->inventory->push(['name' => 'Tornillos Completos','valor'=>'']);
        $this->inventory->push(['name' => 'Difusor','valor'=>'']);

        //si es monofasico
        $this->inventory->push(['name' => 'Capacitor','valor'=>'']);
    }
    public function removeImage($key) {   
        unset($this->photoInventory[$key]);
    }
    public function removeNameplate($key) {   
        unset($this->nameplates[$key]);
    }
    public function next(){
        $this->step++;
        $this->emit('updateStep',$this->step);
    }
    public function prev(){
        $this->step--;
        $this->emit('updateStep',$this->step);
    }
    public function updatedNameplates() {
        $this->emit('updateStep',$this->step);
    }
    public function updatedPhotoInventory() {
        $this->emit('updateStep',$this->step);
    }
    public function updatedphotosMotor() {
        $this->emit('updateStep',$this->step);
    }
    public function gotoStep($step){
        $this->step = $step;
       $this->emit('updateStep',$step);
    }
    // es un listener que viene de cuando se agrega un cliente nuevo
    public function newCustomerAdded($id_customer)
    {
        $this->clientesList = Cliente::orderBy('cliente','asc')->get();
        $this->customer = $id_customer;
        $this->fillContacts();
    }

   
}
