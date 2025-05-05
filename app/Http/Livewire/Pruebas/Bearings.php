<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Grasa;
use App\Models\Motor;
use App\Models\MotorAjuste;
use App\Models\Rodamiento;
use App\Models\RodamientoMarca;
use Livewire\Component;

class Bearings extends Component
{
    public $rodamientos, $grasas,$rpm=null;


    public $bearings, $motor,$marcas;
    public function mount(Motor $motor)
    {
        $this->motor = Motor::find($motor->id_motor);
        for ($i = 0; $i < 4; $i++) {
            $this->bearings[$i]['ajuste'] = $motor->ajustes->where('carga_opuesto', intdiv($i, 2))->where('initial_final', $i % 2)->first();
      
            $this->bearings[$i]['rodamiento_id'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->rodamiento_id : null;
           
            $this->bearings[$i]['sellos'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->sellos : null;
            $this->bearings[$i]['juego_radial'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->juego_radial : null;
            $this->bearings[$i]['jaula'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->jaula : null;
            $this->bearings[$i]['grasa_id'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->grasa_id : null;
            $this->bearings[$i]['aislado'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->aislado : null;
            $this->bearings[$i]['rodamiento_marca_id'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->rodamiento_marca_id : null;
           
            $this->bearings[$i]['p'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->p : null;
            $this->bearings[$i]['q'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->q : null;
            $this->bearings[$i]['r'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->r : null;
            $this->bearings[$i]['s'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->s : null;
            $this->bearings[$i]['t'] = $this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->t : null;
            $this->rpm = $this->rpm==null?($this->bearings[$i]['ajuste'] ? $this->bearings[$i]['ajuste']->rpm : null):$this->rpm;
            $this->bearings[$i]['bearing'] = $this->bearings[$i]['ajuste'] ? Rodamiento::where('id', $this->bearings[$i]['ajuste']->rodamiento_id)->first() : null;
            $this->bearings[$i]['designacion'] = $this->printDesignation($this->bearings[$i]);
            
            
        }

        //f7d83f yellow
    }
    public function render()
    {
        $this->rodamientos = Rodamiento::orderBy('designacion', 'asc')->get();
        $this->grasas = Grasa::orderBy('name', 'asc')->get();
        $this->marcas = RodamientoMarca::orderBy('name', 'asc')->get();
        return view('livewire.pruebas.bearings');
    }


    public function copy_carga($original, $new)
    {

        $this->bearings[$new]['rodamiento_id'] = $this->bearings[$original]['rodamiento_id'];
        $this->bearings[$new]['sellos'] = $this->bearings[$original]['sellos'];
        $this->bearings[$new]['juego_radial'] = $this->bearings[$original]['juego_radial'];
        $this->bearings[$new]['jaula'] = $this->bearings[$original]['jaula'];
        $this->bearings[$new]['grasa_id'] = $this->bearings[$original]['grasa_id'];
        $this->bearings[$new]['designacion'] = $this->bearings[$original]['designacion'];
        $this->bearings[$new]['bearing'] = $this->bearings[$original]['bearing'];
        $this->bearings[$new]['aislado'] = $this->bearings[$original]['aislado'];
        $this->bearings[$new]['rodamiento_marca_id'] = $this->bearings[$original]['rodamiento_marca_id'];
    }



    public function saveBearing($id)
    {


        $validacion = [
            'bearings.' . $id . '.rodamiento_id' => 'required',
            'bearings.' . $id . '.sellos' => 'required',
            'bearings.' . $id . '.juego_radial' => 'required',
            'bearings.' . $id . '.jaula' => 'required',
            'bearings.' . $id . '.grasa_id' => 'required',
            'bearings.' . $id . '.aislado' => 'required',
            'rpm' => 'required|integer|min:1',
            'bearings.' . $id . '.rodamiento_marca_id' => 'required',
        ];
       $this->validate($validacion);
        if ($id % 2 != 0) {
            $this->validate([
                'bearings.' . $id . '.p' => 'required',
                'bearings.' . $id . '.s' => 'required',
                'bearings.' . $id . '.t' => 'required',

            ]);
            if ($this->bearings[$id]['bearing']['diametro_externo'] > 100) {
                $this->validate([
                    'bearings.' . $id . '.q' => 'required',
                ]);
            }
            if ($this->bearings[$id]['bearing']['diametro_externo'] > 200) {
                $this->validate([
                    'bearings.' . $id . '.r' => 'required',
                ]);
            }
        }
        $p = $this->bearings[$id]['p'];
        $q = $this->bearings[$id]['q'];
        $r = $this->bearings[$id]['r'];

        if ($this->bearings[$id]['bearing']['diametro_externo'] <= 200 && $this->bearings[$id]['bearing']['diametro_externo'] > 100) 
            $r = ($q + $p) / 2;
        elseif ($this->bearings[$id]['bearing']['diametro_externo'] <= 100) {
            $r = $p;
            $q = $p;
        } 
          
        $s = $this->bearings[$id]['s'] ? $this->bearings[$id]['s'] : 0;
        $t = $this->bearings[$id]['t'] ? $this->bearings[$id]['t'] : $s;
        if ($this->bearings[$id]['ajuste']) {
            
            $ajuste = MotorAjuste::find($this->bearings[$id]['ajuste']['id']);
            $ajuste->update([
                'rodamiento_id' => $this->bearings[$id]['rodamiento_id'],
                'sellos' => $this->bearings[$id]['sellos'],
                'juego_radial' => $this->bearings[$id]['juego_radial'],
                'jaula' => $this->bearings[$id]['jaula'],
                'grasa_id' => $this->bearings[$id]['grasa_id'],
                'aislado' => $this->bearings[$id]['aislado'],
                'rodamiento_marca_id' => $this->bearings[$id]['rodamiento_marca_id'],
                'rpm' => (int)$this->rpm,
                'p' => $p,
                'q' => $q,
                'r' => $r,
                's' => $s,
                't' => $t,
                
            ]);
        } else
            MotorAjuste::create([
                'id_motor' => $this->motor->id_motor,
                'rodamiento_id' => $this->bearings[$id]['rodamiento_id'],
                'sellos' => $this->bearings[$id]['sellos'],
                'juego_radial' => $this->bearings[$id]['juego_radial'],
                'jaula' => $this->bearings[$id]['jaula'],
                'grasa_id' => $this->bearings[$id]['grasa_id'],
                'aislado' => $this->bearings[$id]['aislado'],
                'rodamiento_marca_id' => $this->bearings[$id]['rodamiento_marca_id'],
                'carga_opuesto' => intdiv($id, 2),
                'initial_final' => $id % 2,
                'rpm' => (int)$this->rpm,
                'p' => $p,
                'q' => $q,
                'r' => $r,
                's' => $s,
                't' => $t,
                
            ]);
        switch ($id) {
            case 0:
                $this->emit('beraring_updated', 'Rodamiento Lado Carga Actualizado', 'Se actualizo la informacion del cojinete usado de carga');
                break;
            case 1:
                $this->emit('beraring_updated', 'Rodamiento Lado Carga Actualizado', 'Se actualizo la informacion del cojinete nuevo de carga');
                break;
            case 2:
                $this->emit('beraring_updated', 'Rodamiento Lado Opuesto Actualizado', 'Se actualizo la informacion del cojinete usado de lado opuesto');
                break;
            case 3:
                $this->emit('beraring_updated', 'Rodamiento Lado Opuesto Actualizado', 'Se actualizo la informacion del cojinete nuevo de lado opuesto');
                break;
        }

        $this->mount($this->motor);
        $this->emitTo(Ajustes::class,'montar',$this->motor);
    }

    public function updatedBearings()
    {
        for ($i = 0; $i < 4; $i++) {
            $this->bearings[$i]['designacion'] = $this->printDesignation($this->bearings[$i]);
            $this->bearings[$i]['bearing'] = $this->bearings[$i]['rodamiento_id'] ? Rodamiento::find($this->bearings[$i]['rodamiento_id']) : null;
        }
    }

    public function printDesignation($bearing)
    {
       
        $designacion = "";
        if ($bearing['rodamiento_id']) {
            $rodamiento =  Rodamiento::where('id', $bearing['rodamiento_id'])->first();
            
            if ($bearing['rodamiento_marca_id']) {

                $marca = RodamientoMarca::where('id', $bearing['rodamiento_marca_id'])->first();
                
                if ($marca) {
                    $designacion = $marca->name . " ";
                    
                }
            }
            $designacion .= $rodamiento->designacion;
            
            switch ($bearing['jaula']) {
                case 1: //j
                    if($rodamiento->tipo==2)
                        $designacion = $designacion . " ECJ";
                    break;
                case 2: //M
                    if($rodamiento->tipo==2)
                        $designacion = $designacion . " ECM";
                    elseif($rodamiento->tipo==1)
                        $designacion = $designacion . " /M";
                    break;
                case 3://p
                    if($rodamiento->tipo==2)
                        $designacion = $designacion . " ECP";
                    break;
            }
            switch ($bearing['sellos']) {
                case 3: //2RS
                    $designacion = $designacion . " 2RS";
                    break;
                case 2: //ZZ
                    $designacion = $designacion . " ZZ";
                    break;
            }
            switch($bearing['juego_radial']){
                case 2: //C3
                    $designacion = $designacion . " C3";
                    break;
                case 3: //C4
                    $designacion = $designacion . " C4";
                    break;
            }
            switch($bearing['aislado']){
                case 2: //INSOCOAT
                    $designacion = $designacion . " VL0241";
                    break;
            }
        }

        return $designacion;
    }
}
