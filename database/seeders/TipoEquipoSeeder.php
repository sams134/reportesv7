<?php

namespace Database\Seeders;

use App\Models\TipoEquipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoEquipo::create(['tipo_equipo' => 'Motor']);
        TipoEquipo::create(['tipo_equipo' => 'Estator']);
        TipoEquipo::create(['tipo_equipo' => 'Rotor']);
        TipoEquipo::create(['tipo_equipo' => 'Generador']);
        TipoEquipo::create(['tipo_equipo' => 'Ventilador']);
        TipoEquipo::create(['tipo_equipo' => 'Bomba']);
        TipoEquipo::create(['tipo_equipo' => 'Compresor']);
        TipoEquipo::create(['tipo_equipo' => 'Trasformador']);
        TipoEquipo::create(['tipo_equipo' => 'Parte Mecanica']);
        TipoEquipo::create(['tipo_equipo' => 'Maquina']);
    }
}
