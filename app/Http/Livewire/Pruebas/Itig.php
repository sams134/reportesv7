<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Motor;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Itig extends Component
{
    use WithFileUploads;

    public $motor;
    public $folder = []; // Aquí se almacenarán los archivos subidos
    public $pruebas = [];
    public $megger = [];

    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
    }

    public function updatedFolder()
    {
        // Reinicia el array de pruebas
        $this->pruebas = [];


        foreach ($this->folder as $file) {
            $name = $file->getClientOriginalName();
            $type = explode('_', $name);
            // Se extraen los valores según la estructura del nombre
            if (count($type) > 2) {
                $date = $type[1];
            }
            if ($type[0] == 'S') {
                $number = $type[3];
                $fileTxt = file_get_contents($file->getRealPath());
                $fileTxt = explode("\r\n", $fileTxt);
                foreach ($fileTxt as $line) {
                    $lineData = explode(",", $line);
                    if (count($lineData) < 3) {
                        // Guarda el dato en el array para la fecha y el dataset correspondiente
                        $this->pruebas[$date][$number][] = $lineData[0];
                    }
                }
            }elseif ($type[0] == 'M'){
                $number = $type[2];
                $fileTxt = file_get_contents($file->getRealPath());
                $fileTxt = explode("\r\n", $fileTxt);
                for ($i=7;$i<count($fileTxt)-1;$i++){
                    $lineData = explode(",", $fileTxt[$i]);
                    if (count($lineData) > 2) {
                        // Guarda el dato en el array para la fecha y el dataset correspondiente
                        $this->megger[$number]['date'] = $date;
                        $this->megger[$number]['voltage'][] = (double)$lineData[1];
                        $this->megger[$number]['current'][] = (double)$lineData[2];
                        $this->megger[$number]['resistance'][] = (double)$lineData[1]/((double)$lineData[2]+0.001);
                        $this->megger[$number]['time'][] = (double)$lineData[0];
                    }
                }
            }
        }
        dd($this->megger);
        // Emitir un evento para indicar que ya se pueden renderizar las gráficas
       
        if (count($this->pruebas) > 0)
            $this->emit('renderCharts', $this->pruebas);
        if (count($this->megger) > 0)
            $this->emit('renderMegger', $this->megger);
    }
    public function uploadFiles()
    {
        $this->validate([
            'folder.*' => 'required|file|mimes:dt1,txt,csv,mhe,',
        ]);

        $folderPath = '/uploads/' . "2M" . $this->motor->year . '-' . $this->motor->os . '/surge';

        foreach ($this->folder as $file) {
            //$uniqueFileName = $file->getClientOriginalName();
            //$file->storeAs($folderPath, $uniqueFileName, 'public');
        }

        session()->flash('message', 'Archivos subidos correctamente a la carpeta temporal.');
    }

    public function render()
    {
        return view('livewire.pruebas.itig');
    }
}
