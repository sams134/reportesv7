<?php

namespace App\Http\Livewire\Motors;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Contacto;
use App\Models\Motor;
use App\Models\TipoEquipo;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMotor extends Component
{
    use WithFileUploads;
    public $clientesList, $customer_id = "", $contactList = array(), $equipmentTypes, $year, $os, $inDate, $fechaSpanish, $emailTo = [], $emailToReal = [], $preAutorizado = false;
    public $inventory, $customer, $emergencyLevel = 1, $comentariosCliente;
    public $photoInventory = [];
    public $nameplates = [];
    public $photosMotor = ['', '', '', ''];
    public $step = 0;
    //placa de datos
    public $equipmentName, $equipmentType=null, $selectedEquipmentTypeName,$potencia,$aproximado=false,$powerUnit=0,$rpm,$marca,$serie,$modelo,$voltaje,$amperaje,$frame,$hz,$inverter;

    public $listeners = ['next', 'prev', 'newCustomerAdded', 'render','store'];
    protected $rules = [
        'customer_id' => 'required',
        'inventory.*.name' => '',
        'inventory.*.valor' => '',
        'photoInventory.*' => 'sometimes|image|max:2048', // 2MB Max
        'nameplates.*' => 'sometimes|image|max:2048', // 2MB Max
        'photosMotor.*' => 'sometimes|image|max:2048', // 2MB Max
        'emailTo.*.id' => '',
        'year' => 'required|integer',
        'os' => 'required|string',
        
    ];


    public function mount()
    {

        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES');
        $this->year = Config::find(1)->year;
        $this->os = Motor::where('year', "2M" . $this->year)->max('os');
        $this->os = $this->os + 1;
        $this->os = str_pad("" . $this->os, 4, "0", STR_PAD_LEFT);
        $this->inDate = Carbon::now()->format('d-m-Y');
        $this->equipmentTypes = TipoEquipo::orderBy('tipo_equipo','asc')->get();;
        $this->inventory = collect();
        $this->addInventoryParts();
        $this->fechaSpanish = Carbon::createFromFormat('d-m-Y', $this->inDate);
        $this->fechaSpanish = $this->fechaSpanish->formatLocalized('%d de %B de %Y');
    }
    public function render()
    {

        $this->clientesList = Cliente::orderBy('cliente', 'asc')->get();
        if ($this->customer_id != "")
            $this->contactList = Contacto::where('id_cliente', $this->customer_id)->get();
        return view('livewire.motors.create-motor');
    }
    public function fillContacts()
    {
        $this->customer = Cliente::find($this->customer_id);
        $this->emailTo = [];
        $this->render();
    }
    public function addInventoryParts()
    {
        $this->inventory->push(['name' => 'Acople o polea', 'valor' => '4']);
        $this->inventory->push(['name' => 'Caja de Conexiones', 'valor' => '4']);
        $this->inventory->push(['name' => 'Tapa caja de conexiones', 'valor' => '4']);
        $this->inventory->push(['name' => 'Difusor', 'valor' => '4']);
        $this->inventory->push(['name' => 'Ventilador', 'valor' => '4']);
        $this->inventory->push(['name' => 'Bornera', 'valor' => '4']);
        $this->inventory->push(['name' => 'Cuña', 'valor' => '4']);
        $this->inventory->push(['name' => 'Graseras', 'valor' => '4']);
        $this->inventory->push(['name' => 'Cancamo', 'valor' => '4']);
        $this->inventory->push(['name' => 'Placa de Datos', 'valor' => '4']);
        $this->inventory->push(['name' => 'Tornillos Completos', 'valor' => '4']);
        $this->inventory->push(['name' => 'Difusor', 'valor' => '4']);

        //si es monofasico
        $this->inventory->push(['name' => 'Capacitor', 'valor' => '4']);
    }
    public function removeImage($key)
    {
        unset($this->photoInventory[$key]);
    }
    public function removeNameplate($key)
    {
        unset($this->nameplates[$key]);
    }
    public function next()
    {
        if ($this->step == 4){
            $this->emit('updateStep', $this->step);
            $this->store();
        }
        

        elseif ($this->validateStep($this->step)) {
            $this->step++;
            $this->emit('updateStep', $this->step);
        }
    }
    public function prev()
    {
        $this->step--;
        $this->emit('updateStep', $this->step);
    }
    public function updatedNameplates()
    {
        $this->emit('updateStep', $this->step);
    }
    public function updatedPhotoInventory()
    {
        $this->emit('updateStep', $this->step);
    }
    public function updatedphotosMotor()
    {
        $this->emit('updateStep', $this->step);
    }
    public function updatedMarca()
    {
        $this->marca = strtoupper($this->marca);
    }
    public function updatedModelo()
    {
        $this->modelo = strtoupper($this->modelo);
    }
    public function updatedSerie()
    {
        $this->serie = strtoupper($this->serie);
    }
    public function updatedFrame()
    {
        $this->frame = strtoupper($this->frame);
    }
    public function updatedOS(){
        $this->os = str_pad("" . $this->os, 4, "0", STR_PAD_LEFT);
    }
    public function gotoStep($step)
    {
        $validated = true;
        $failedStep = $this->step;
        for($i=$this->step;$i<$step && $validated;$i++)
            $validated = $this->validateStep($failedStep++);
        if ($validated) {
            $this->step = $step;
            $this->emit('updateStep', $step);
        }else{
            $this->step = $failedStep-1;
            $this->emit('updateStep', $this->step);
            $this->validateStep($this->step);
        }
    }
    public function updatedEmailTo()
    {
        $this->emailToReal = Contacto::whereIn('id', $this->emailTo)->get()->toArray();
    }
    public function updatedEquipmentType($value)
    {
        $selectedEquipmentType = TipoEquipo::find($value);
        
        $this->selectedEquipmentTypeName = $selectedEquipmentType->tipo_equipo;
    }
    public function updated()
    {
        $date = DateTime::createFromFormat('d-m-Y', $this->inDate);
        if ($date === false) {
            // La fecha no está en el formato especificado, se establece la fecha de hoy en ese formato
            $this->inDate = date('d-m-Y');
        } else {
            // La fecha está en el formato especificado, se establece la fecha en ese formato
            $this->inDate = $date->format('d-m-Y');
        }
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES');
       
        $this->fechaSpanish = Carbon::createFromFormat('d-m-Y', $this->inDate);
        $this->fechaSpanish = $this->fechaSpanish->formatLocalized('%d de %B de %Y');
    }

    // es un listener que viene de cuando se agrega un cliente nuevo
    public function newCustomerAdded($id_customer)
    {
        $this->clientesList = Cliente::orderBy('cliente', 'asc')->get();
        $this->customer_id = $id_customer;
        $this->fillContacts();
    }
    public function store()
    {
       // $motor->contactos()->attach($emailTo);
      

       try {
        $this->validate();
        $motor = Motor::create([
            'year' => "2M".$this->year,
            'os' => $this->os,
            'id_cliente' => $this->customer_id,
            'hp' => $this->potencia,
            'hpkw' => $this->powerUnit,
            'serie' => $this->serie,
            'modelo' => $this->modelo,
            'marca' => $this->marca,
            'rpm' => $this->rpm,
            'volts' => $this->voltaje,
            'amps' => $this->amperaje,
            'frame' => $this->frame,
            'hz' => $this->hz,
            'id_tipoequipo' => $this->equipmentType,
            'fecha_ingreso' => date('Y-m-d', strtotime($this->inDate)),
        ]);
        $motor->contactos()->attach($this->emailTo);
        return redirect()->route('motores.index')->with('success','La OS '.$this->year.'-'.$this->os. ' fue guardado exitosamente.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Acceder a los errores de validación
        $errors = $e->validator->getMessageBag();
       dd($errors);
    }

       

    }

    public function validateStep($step)
    {
        return true; // quitar
        switch ($step) {
            case 0:
                if ($this->customer_id == '') {
                    $this->addError('cliente', 'Debe seleccionar un cliente');
                    return false;
                }
                if ($this->year > 30 || $this->year < 17){
                    $this->addError('year', 'Ese Año es invalido');
                    return false;
                }
                if (!is_numeric($this->os)){
                    $this->addError('os', 'Esa OS es invalida');
                    return false;
                }
               
                break;
               
                  
            case 1:
               
                $this->potencia = preg_replace('/\s+/', '', $this->potencia); // Elimina los espacios en blanco
                $this->potencia = preg_replace_callback('/(\d+(?:\.\d+)?)\s*(watts?|w)/i', function($matches) {
                    $this->powerUnit = 1;
                    return $matches[1] / 1000;
                }, $this->potencia);
                if ($this->equipmentType == null) {
                    $this->addError('tipo_equipo', 'Debe seleccionar un tipo de equipo');
                    return false;
                }
                if ($this->potencia == "")
                  $this->potencia = 0;
                elseif (preg_match('/^[0-9\/\+\-\*\(\)\.]+$/', $this->potencia)) { // Verifica si la entrada es válida
                    eval("\$this->potencia = ($this->potencia);"); // Evalúa la expresión aritmética
                }else
                {
                    $this->addError('hp', 'Potencia invalida');
                    return false;
                }
                break;
        }
        return true;
    }
}
