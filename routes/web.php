<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MotorController;
use App\Http\Livewire\Customers\IndexCustomers;
use App\Http\Livewire\Motors\IndexMotors;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Customers\CreateCustomers;
use App\Http\Livewire\Customers\EditCustomer;

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

Route::get('/', function () {
    return view('dashboard');
});



// Clientes

//Route::resource('clientes',ClienteController::class);
//Route::resource('motores',MotorController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/clientes', IndexCustomers::class)->name('clientes.index');
    Route::get('/clientes/create', CreateCustomers::class)->name('clientes.create');
    Route::get('/clientes/{c}/edit', EditCustomer::class)->name('clientes.edit');
    Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');



    Route::get('/motores', IndexMotors::class)->name('motores.index');
    Route::get('/motores/create', [MotorController::class, 'create'])->name('motores.create');
});
