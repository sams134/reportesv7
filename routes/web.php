<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotorController;
use App\Http\Livewire\Customers\IndexCustomers;
use App\Http\Livewire\Motors\IndexMotors;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Customers\CreateCustomers;
use App\Http\Livewire\Customers\EditCustomer;
use App\Http\Livewire\Customers\ShowCustomers;
use App\Http\Livewire\Materiales\MaterialesIndex;
use App\Http\Livewire\Motors\CreateMotor;
use App\Http\Livewire\Motors\ShowMotor;

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
    Route::get('/motores/{motor}',ShowMotor::class)->name('motores.show');
    Route::get('/motores/pdfIngreso/{motor}',[MotorController::class,'downloadPdf'])->name('motores.downloadPdf');
    Route::get('/motores/pdf-densidades/{motor}',[MotorController::class,'downloadPdfDensidades'])->name('motores.downloadPdfDensidades');
    Route::get('/motores/pdf-balanceo/{motor}',[MotorController::class,'downloadPdfBalanceo'])->name('motores.downloadPdfBalanceo');


    Route::get('/materiales',MaterialesIndex::class)->name('materiales.index');
});
