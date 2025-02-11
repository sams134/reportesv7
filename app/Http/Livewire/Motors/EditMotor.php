<?php

namespace App\Http\Livewire\Motors;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Contacto;
use App\Models\Foto;
use App\Models\InfoMotor;
use App\Models\Inventario;
use App\Models\Motor;
use App\Models\TipoEquipo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EditMotor extends Component
{
    use WithFileUploads;

    public $motor;
    public $step = 0;
    public $clientesList, $customer_id = "", $contactList = array(), $equipmentTypes, $year, $os, $inDate, $fechaSpanish, $emailTo = [], $emailToReal = [], $preAutorizado = false;
    public $inventory, $customer, $emergencyLevel = 1, $comentariosCliente, $inventoryComments,$previusNamePlates;
    public $photoInventory = [],$previusPhotoInventory;
    public $nameplates = [];
    public $photosMotor = ['', '', '', ''],$photosMotorDB;
    public $equipmentName, $equipmentType = null, $selectedEquipmentTypeName, $potencia, $aproximado = false, $powerUnit = 0, $rpm, $marca, $serie, $modelo, $voltaje, $amperaje, $frame, $hz, $inverter, $pf, $eff,$phases;
    public $listeners = ['next', 'prev', 'newCustomerAdded', 'render', 'store', 'removeNameplateDB', 'removePhotoDB','removeInventoryPhotoDB'];
    protected $rules = [
        'customer_id' => 'required',
        'inventory.*.name' => '',
        'inventory.*.valor' => '',
        'photoInventory.*' => 'sometimes|image', // Ya no hay límite de tamaño
        'nameplates.*' => 'sometimes|image', // Ya no hay límite de tamaño
        'photosMotor.*' => 'sometimes|image', // Ya no hay límite de tamaño
        'emailTo.*.id' => '',
        'year' => 'required|integer',
        'os' => 'required|string',
    ];


    public function mount(Motor $motor)
    {
        $this->motor = $motor->load('contactos');
    
        $this->year = (int) str_replace('2M', '', $motor->year);
        $this->os = $motor->os;
        $this->customer_id = $motor->id_cliente;
        $this->customer = Cliente::find($motor->id_cliente);
        $this->equipmentType = $motor->id_tipoequipo;
        $this->equipmentName = $motor->infoMotor->nombre_equipo;
        $this->potencia = $motor->hp;
        $this->aproximado = $motor->infoMotor->reales == 1 ? false : true;
        $this->powerUnit = $motor->hpkw;
        $this->rpm = $motor->rpm;
        $this->marca = $motor->marca;
        $this->serie = $motor->serie;
        $this->modelo = $motor->modelo;
        $this->voltaje = $motor->volts;
        $this->amperaje = $motor->amps;
        $this->frame = $motor->frame;
        $this->hz = $motor->hz;
        $this->phases = $motor->phases;
        $this->inverter = $motor->inverter;
        $this->pf = $motor->pf;
        $this->eff = $motor->eff;
        $this->inverter = $motor->inverter_duty;
        
        $this->inventory = collect();
        $this->addInventoryParts();
        

        //$this->contactList = $this->customer->contactos;
        //$this->emailTo = $motor->contactos;
        
        $this->preAutorizado = ($motor->infoMotor->cotizar == "Si, Empezar a trabajar")?true:false;        
        $this->emergencyLevel = $motor->infoMotor->emergenciaValue;
        $this->comentariosCliente = $motor->comentarios;
        $this->inventoryComments = $motor->inventario->comentarios;


        $this->equipmentTypes = TipoEquipo::orderBy('name', 'asc')->get();;
        // $this->selectedEquipmentTypeName = $motor->tipo_equipo->nombre;

        $this->inDate = new DateTime($motor->fecha_ingreso);
        $this->inDate = $this->inDate->format('d-m-Y');
        $this->fechaSpanish = Carbon::createFromFormat('d-m-Y', $this->inDate);

        $this->emailTo = $this->motor->contactos()
            ->select('contactos.id')
            ->pluck('id')
            ->toArray();

       
        $this->previusNamePlates = $motor->fotos->where('type', Foto::NAMEPLATE);
        $this->previusPhotoInventory = $motor->fotos->where('type', Foto::INVENTORY);
        $this->photosMotorDB = $motor->fotos->whereIn('type', [Foto::MOTOR, Foto::TRABAJO])->take(4);
        
        

        //nameplates
        //dd($this->emailTo);
    }
    public function addInventoryParts()
    {
        $this->inventory->push(['name' => 'Acople o polea', 'valor' => $this->motor->inventario->acople]);
        $this->inventory->push(['name' => 'Caja de Conexiones', 'valor' => $this->motor->inventario->caja_conexiones]);
        $this->inventory->push(['name' => 'Tapa caja de conexiones', 'valor' => $this->motor->inventario->tapa_caja]);
        $this->inventory->push(['name' => 'Difusor', 'valor' => $this->motor->inventario->difusor]);
        $this->inventory->push(['name' => 'Ventilador', 'valor' => $this->motor->inventario->ventilador]);
        $this->inventory->push(['name' => 'Bornera', 'valor' => $this->motor->inventario->bornera]);   
        $this->inventory->push(['name' => 'Cuña', 'valor' => $this->motor->inventario->cunia]);
        $this->inventory->push(['name' => 'Graseras', 'valor' => $this->motor->inventario->graseras]);
        $this->inventory->push(['name' => 'Cancamo', 'valor' => $this->motor->inventario->cancamo]);
        $this->inventory->push(['name' => 'Placa de Datos', 'valor' => $this->motor->inventario->placa]);
        $this->inventory->push(['name' => 'Tornillos Completos', 'valor' => $this->motor->inventario->tornillos]);

        //si es monofasico
        $this->inventory->push(['name' => 'Capacitor', 'valor' => $this->motor->inventario->capacitor]);
    }
    public function next()
    {
        if ($this->step == 4) {
            $this->emit('updateStep', $this->step);
            $this->update();
        } elseif ($this->validateStep($this->step)) {
            $this->step++;
            $this->emit('updateStep', $this->step);
        }
    }
    public function prev()
    {
        $this->step--;
        $this->emit('updateStep', $this->step);
    }
    public function updatedEmailTo()
    {
        $this->emailToReal = Contacto::whereIn('id', $this->emailTo)->get()->toArray();
    }
    public function gotoStep($step)
    {
        $validated = true;
        $failedStep = $this->step;
        for ($i = $this->step; $i < $step && $validated; $i++)
            $validated = $this->validateStep($failedStep++);
        if ($validated) {
            $this->step = $step;
            $this->emit('updateStep', $step);
        } else {
            $this->step = $failedStep - 1;
            $this->emit('updateStep', $this->step);
            $this->validateStep($this->step);
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
                if ($this->year > 30 || $this->year < 17) {
                    $this->addError('year', 'Ese Año es invalido');
                    return false;
                }
                if (!is_numeric($this->os)) {
                    $this->addError('os', 'Esa OS es invalida');
                    return false;
                }

                break;


            case 1:

                $this->potencia = preg_replace('/\s+/', '', $this->potencia); // Elimina los espacios en blanco
                $this->potencia = preg_replace_callback('/(\d+(?:\.\d+)?)\s*(watts?|w)/i', function ($matches) {
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
                } else {
                    $this->addError('hp', 'Potencia invalida');
                    return false;
                }
                break;
        }
        return true;
    }
    public function removeNameplateDB($key)
    {
       Foto::find($key)->delete();
       $this->motor = Motor::find($this->motor->id_motor);
         $this->previusNamePlates = $this->motor->fotos->where('type', Foto::NAMEPLATE);
        $this->gotoStep(1);
    }
    public function removePhotoDB($key)
    {
        Foto::find($key)->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->photosMotorDB = $this->motor->fotos->whereIn('type', [Foto::MOTOR, Foto::TRABAJO])->take(4);
        $this->gotoStep(3);
    }
    public function removeInventoryPhotoDB($key)
    {
        Foto::find($key)->delete();
        $this->motor = Motor::find($this->motor->id_motor);
        $this->previusPhotoInventory = $this->motor->fotos->where('type', Foto::INVENTORY);
        $this->gotoStep(2);
    }
    public function update(){
        
        $this->validate();
        
        $folderPath = '/uploads/' . "2M" . $this->year . '-' . $this->os . '/ingreso';
        Storage::disk('public')->makeDirectory($folderPath); // Asegúrate de usar el disco correcto
        try {
            $this->motor->year = "2M".$this->year;
            $this->motor->os = $this->os;
            $this->motor->id_cliente = $this->customer_id;
            $this->motor->fecha_ingreso = date('Y-m-d', strtotime($this->inDate));
            $this->motor->id_tipoequipo = $this->equipmentType;
            $this->motor->hp = $this->potencia;
            $this->motor->hpkw = $this->powerUnit;
            $this->motor->rpm = $this->rpm;
            $this->motor->marca = $this->marca;
            $this->motor->serie = $this->serie;
            $this->motor->modelo = $this->modelo;
            $this->motor->volts = $this->voltaje;
            $this->motor->amps = $this->amperaje;
            $this->motor->frame = $this->frame;
            $this->motor->hz = $this->hz;
            $this->motor->phases = $this->phases;
            
            $this->motor->pf = $this->pf;
            $this->motor->eff = $this->eff;
            $this->motor->inverter_duty = $this->inverter;
            $this->motor->comentarios = $this->comentariosCliente;
            $this->motor->inventario->comentarios = $this->inventoryComments;
            $this->motor->infoMotor->cotizar = $this->preAutorizado ? 0:1;
            $this->motor->infoMotor->emergencia = $this->emergencyLevel;
            $this->motor->infoMotor->reales = $this->aproximado ? 0 : 1;
            $this->motor->infoMotor->nombre_equipo = $this->equipmentName;
            
            $this->motor->infoMotor->save();
            
            $this->motor->contactos()->sync($this->emailTo);

            
            $this->motor->save();
            $this->motor->inventario->acople = $this->inventory[0]['valor'];
            $this->motor->inventario->caja_conexiones = $this->inventory[1]['valor'];
            $this->motor->inventario->tapa_caja = $this->inventory[2]['valor'];
            $this->motor->inventario->difusor = $this->inventory[3]['valor'];
            $this->motor->inventario->ventilador = $this->inventory[4]['valor'];
            $this->motor->inventario->bornera = $this->inventory[5]['valor'];
            $this->motor->inventario->cunia = $this->inventory[6]['valor'];
            $this->motor->inventario->graseras = $this->inventory[7]['valor'];
            $this->motor->inventario->cancamo = $this->inventory[8]['valor'];
            $this->motor->inventario->placa = $this->inventory[9]['valor'];
            $this->motor->inventario->tornillos = $this->inventory[10]['valor'];
            $this->motor->inventario->capacitor = $this->inventory[11]['valor'];
            $this->motor->inventario->save();
            
            $this->savePhotos($this->nameplates, $folderPath, Foto::NAMEPLATE, $this->motor->id_motor);
            $this->savePhotos($this->photoInventory, $folderPath, Foto::INVENTORY, $this->motor->id_motor);
            $this->savePhotos($this->photosMotor, $folderPath, Foto::MOTOR, $this->motor->id_motor);
            $this->emit('motorUpdated');
            return redirect()->route('motores.index')->with('success', 'La OS ' . $this->year . '-' . $this->os . ' fue editada exitosamente.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('motores.index')->with('error', 'Hubo un error al actualizar la OS: ' . $e->getMessage());
        }
    }

    private function savePhotos($photos, $folderPath, $type, $motorId)
    {
        if (!$motorId) {
            throw new \Exception('El ID del motor es inválido');
        }

        if ($photos) {
            foreach ($photos as $photo) {
                // Crear la imagen con Intervention
                if ($photo != "") {
                    $image = Image::make($photo);

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

                    // Guardar la información en la tabla 'fotos'
                    Foto::create([
                        'foto' => $imagePath,
                        'thumb' => $imagePath,
                        'id_motor' => $motorId,
                        'type' => $type,
                    ]);
                }
            }
        }
    }


    public function render()
    {
        $this->clientesList = Cliente::orderBy('cliente', 'asc')->get();
        if ($this->customer_id != "")
            $this->contactList = Contacto::where('id_cliente', $this->customer_id)->get();
        return view('livewire.motors.edit-motor');
    }
}
