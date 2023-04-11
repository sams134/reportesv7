<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('statuses')->delete();
        Status::create(['id' => '-1','status' => 'No Asignado']);
        Status::create(['id' => '0','status' => 'No Autorizado']);
        Status::create(['id' => '1','status' => 'Diagnostico']);
        Status::create(['id' => '2','status' => 'Diagnostico pendiente de autorizacion']);
        Status::create(['id' => '3','status' => 'Autorizado Parcial / Ver Pendientes']);
        Status::create(['id' => '4','status' => 'Autorizado Completamente']);
        Status::create(['id' => '5','status' => 'Retrasado']);
        Status::create(['id' => '6','status' => 'Garantia']);
        Status::create(['id' => '7','status' => 'Emergencia']);
        Status::create(['id' => '8','status' => 'Alta Emergencia']);
        Status::create(['id' => '9','status' => 'Finalizado']);
        Status::create(['id' => '10','status' => 'En Traslado']);
        Status::create(['id' => '11','status' => 'Entregado sin reparacion']);
        Status::create(['id' => '12','status' => 'EPF']);
        Status::create(['id' => '13','status' => 'Aceptacion, Pendiente Facturacion']);
        Status::create(['id' => '14','status' => 'Facturado, Pendiente de pago']);
        Status::create(['id' => '15','status' => 'Pagado']);
    }
}
