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

class CreateMotor extends Component
{
    use WithFileUploads;
    public $clientesList, $customer_id = "", $contactList = array(), $equipmentTypes, $year, $os, $inDate, $fechaSpanish, $emailTo = [], $emailToReal = [], $preAutorizado = false;
    public $inventory, $customer, $emergencyLevel = 1, $comentariosCliente, $inventoryComments;
    public $photoInventory = [];
    public $nameplates = [];
    public $photosMotor = ['', '', '', ''];
    public $step = 0;
    //placa de datos
    public $equipmentName, $equipmentType = null, $selectedEquipmentTypeName, $potencia, $aproximado = false, $powerUnit = 0, $rpm, $marca, $serie, $modelo, $voltaje, $amperaje, $frame, $hz, $inverter, $pf, $eff;

    public $listeners = ['next', 'prev', 'newCustomerAdded', 'render', 'store'];
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


    public function mount()
    {

        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES');
        $this->year = Config::find(1)->year;
        $this->os = Motor::where('year', "2M" . $this->year)->max('os');
        $this->os = $this->os + 1;
        $this->os = str_pad("" . $this->os, 4, "0", STR_PAD_LEFT);
        $this->inDate = Carbon::now()->format('d-m-Y');
        $this->equipmentTypes = TipoEquipo::orderBy('name', 'asc')->get();;
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
        if ($this->step == 4) {
            $this->emit('updateStep', $this->step);
            $this->store();
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
    public function updatedOS()
    {
        $this->os = str_pad("" . $this->os, 4, "0", STR_PAD_LEFT);
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

    // Grbamos en las tablas motors, inventarios, fotos y info_motor

    public function store()
    {

        try {
            $this->validate();

            // Crear la carpeta donde se van a almacenar las imágenes
            $folderPath = '/uploads/' . "2M" . $this->year . '-' . $this->os . '/ingreso';
            Storage::disk('public')->makeDirectory($folderPath); // Asegúrate de usar el disco correcto

            // Crear el siguiente valor de OS si ya existe el mismo year y os
            $baseYear = "2M" . $this->year;

            // Verificar si ya existe un motor con este OS y año
            $existingMotor = Motor::where('year', $baseYear)
                ->where('os', $this->os)
                ->first();

            if ($existingMotor) {
                // Buscar el máximo OS en el mismo año
                $maxOs = Motor::where('year', $baseYear)->max('os');
                $newOs = (int)$maxOs + 1; // Incrementar el OS
                $this->os = str_pad($newOs, 4, '0', STR_PAD_LEFT); // Padding zero a 4 dígitos
            }


            // Crear el motor en la base de datos
            $motor = Motor::create([
                'year' => "2M" . $this->year,
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
                'pf' => $this->pf,
                'eff' => $this->eff,
                'recibido' => Auth::user()->name,
                'id_tipoequipo' => $this->equipmentType,
                'fecha_ingreso' => date('Y-m-d', strtotime($this->inDate)),
            ]);

            // Verificar que el motor fue creado correctamente
            if (!$motor) {
                throw new \Exception('No se pudo crear el motor');
            }

            $this->saveInventory($motor->id_motor);
            $this->saveInfoMotor($motor);

            // Función para guardar imágenes en la carpeta y la base de datos

            $this->savePhotos($this->photoInventory, $folderPath, 12, $motor->id_motor);
            $this->savePhotos($this->nameplates, $folderPath, 13, $motor->id_motor);
            $this->savePhotos($this->photosMotor, $folderPath, 2, $motor->id_motor);

            // Redirigir a la vista de listado de motores con mensaje de éxito
            return redirect()->route('motores.index')->with('success', 'La OS ' . $this->year . '-' . $this->os . ' fue guardado exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Acceder a los errores de validación
            $errors = $e->validator->getMessageBag();
            dd($errors);
        } catch (\Exception $e) {
            // Capturar otros errores
            dd($e->getMessage()); // Esto te permitirá ver si hay errores relacionados con la creación del motor
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

    public function saveInfoMotor(Motor $motor)
    {
        InfoMotor::create([
            'id_motor' => $motor->id_motor,
            'emergencia' => $this->emergencyLevel,
            'nombre_equipo' => $this->equipmentName,
            'contacto' => isset($this->contactList[0]) ? $this->contactList[0]->contacto : 'Sin contacto',
            'email' => isset($this->contactList[0]) ? $this->contactList[0]->email : 'Sin email',
            'telefono' => isset($this->contactList[0]) ? $this->contactList[0]->telefono : 'Sin teléfono',
            'cotizar' => $this->preAutorizado == true ? 0 : 1,
        ]);
    }
    public function saveInventory($id_motor)
    {
        Inventario::create([
            'id_motor' => $id_motor,
            'acople' => $this->inventory[0]['valor'],
            'caja_conexiones' => $this->inventory[1]['valor'],
            'tapa_caja' => $this->inventory[2]['valor'],
            'difusor' => $this->inventory[3]['valor'],
            'ventilador' => $this->inventory[4]['valor'],
            'bornera' => $this->inventory[5]['valor'],
            'cunia' => $this->inventory[6]['valor'],
            'graseras' => $this->inventory[7]['valor'],
            'cancamo' => $this->inventory[8]['valor'],
            'placa' => $this->inventory[9]['valor'],
            'tornillos' => $this->inventory[10]['valor'],
            'capacitor' => $this->inventory[11]['valor'],
            'comentarios' => $this->inventoryComments,
        ]);
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
}
