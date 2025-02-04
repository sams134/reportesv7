<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clientes = Cliente::orderBy('cliente', 'asc')->get();
        return view('clientes.index', compact('clientes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //


        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    public function getMotorsByYear(Cliente $cliente)
    {
        // Obtenemos los motores del cliente solo con el campo 'year'
        $motorsByYear = $cliente->motors()
             ->selectRaw('substr(year, 3, 2) as year, count(*) as count')
            ->where('year', 'like', '2M%') // Filtrar solo los años con el formato '2M'
            ->groupByRaw('substr(year, 3, 2)')
            ->orderByRaw('year') 
            ->get();


      //  return response()->json($motorsByYear);

        // Obtener todos los años desde el año más bajo hasta el año actual
       // Obtener el rango de años de los motores disponibles
    $years = $motorsByYear->pluck('year')->map(function ($year) {
        return '20' . $year; // Convertir los años de "20" a "2020"
    });

    $motorCounts = $motorsByYear->pluck('count');
    
    $years = $years->reverse()->values();
    $motorCounts = $motorCounts->reverse()->values();
    // Devuelve los datos de años y el conteo de motores
    return response()->json([
        'years' => $years,
        'motor_counts' => $motorCounts
    ]);
    }
}
