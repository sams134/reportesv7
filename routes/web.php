<?php

use App\Http\Controllers\Calculos;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotorController;
use App\Http\Livewire\Admin\CreateEnvio;
use App\Http\Livewire\Admin\Produccion;
use App\Http\Livewire\Balanceo\CreateBalanceo;
use App\Http\Livewire\Boards\IndexBoard;
use App\Http\Livewire\Customers\IndexCustomers;
use App\Http\Livewire\Motors\IndexMotors;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Customers\CreateCustomers;
use App\Http\Livewire\Customers\EditCustomer;
use App\Http\Livewire\Customers\ShowCustomers;
use App\Http\Livewire\Materiales\MaterialesIndex;
use App\Http\Livewire\Metalizados\MetalizadosCreate;
use App\Http\Livewire\Metalizados\MetalizadosIndex;
use App\Http\Livewire\Motors\CreateMotor;
use App\Http\Livewire\Motors\EditMotor;
use App\Http\Livewire\Motors\ShowMotor;
use App\Models\BalanceoArt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Clientes

//Route::resource('clientes',ClienteController::class);
//Route::resource('motores',MotorController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/clientes', IndexCustomers::class)->name('clientes.index');
    
    Route::get('/clientes/create', CreateCustomers::class)->name('clientes.create');
    Route::get('/clientes/{c}/edit', EditCustomer::class)->name('clientes.edit');
    Route::get('/clientes/{cliente}', ShowCustomers::class)->name('clientes.show');



    Route::get('/motores', IndexMotors::class)->name('motores.index');
    Route::get('/motores/search/{search}', IndexMotors::class)->name('motores.index.search');
    Route::get('/motores/create', CreateMotor::class)->name('motores.create');
    Route::get('/motores/{motor}/edit',EditMotor::class)->name('motores.edit');
    Route::get('/motores/{motor}',ShowMotor::class)->name('motores.show');
    Route::get('/motores/lookfor/{motor}',[MotorController::class,'showAndSave'])->name('motores.look');
    Route::get('/motores/pdfIngreso/{motor}',[MotorController::class,'downloadPdf'])->name('motores.downloadPdf');
    Route::get('/motores/pdf-densidades/{motor}',[MotorController::class,'downloadPdfDensidades'])->name('motores.downloadPdfDensidades');
    Route::get('/motores/pdf-balanceo/{motor}',[MotorController::class,'downloadPdfBalanceo'])->name('motores.downloadPdfBalanceo');
    Route::get('/motores/pdf-materiales/{motor}',[MotorController::class,'downloadPdfMateriales'])->name('motores.downloadPdfMateriales');
    Route::get('/motores/createBalanceo/{motor}',CreateBalanceo::class)->name('motores.createBalanceo');
    Route::get('/materiales',MaterialesIndex::class)->name('materiales.index');

    Route::get('/metalizados', MetalizadosIndex::class)->name('metalizados.index');
    Route::get('/metalizados/create', MetalizadosCreate::class)->name('metalizados.create');


    //Calculos
    Route::get('/calculos/ajustes', [Calculos::class, 'ajustesShow'])->name('calculos.ajustes');


    //admin
    Route::get('/admin/CreateEnvio/{motor}', CreateEnvio::class)->name('admin.createEnvio');
    Route::get('/admin/envioPDF/{motor}', [MotorController::class,'downloadPdfEnvio'])->name('admin.envioPDF');
    Route::get('/admin/produccion',Produccion::class)->name('admin.produccion');
    Route::get('/admin/produccionPDF', [MotorController::class,'downloadPdfProduccion'])->name('admin.produccionPDF');
    Route::get('/admin/produccionPDF/{fecha}', [MotorController::class,'downloadPdfProduccion'])->name('admin.produccionPDF.fecha');

    //boards
    Route::get('/boards/{board}', IndexBoard::class)->name('boards.index');


    //API
    Route::get('/balanceo/arts', function () {
        return response()->json(BalanceoArt::orderBy('id', 'desc')->get());
    });
   
});
