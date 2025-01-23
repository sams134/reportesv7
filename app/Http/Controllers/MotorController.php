<?php

namespace App\Http\Controllers;

use App\Models\Motor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $motores = Motor::orderBy('year','desc')->orderBy('os','desc')->paginate(300);
        return view('motores.index',compact('motores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('motores.create');
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
      
      
       $imagen =  $request->file('file')->store('public/imagenes');
       $url = Storage::url($imagen);
       echo $url;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function show(Motor $motor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function edit(Motor $motor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motor $motor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motor $motor)
    {
        //
    }

    public function downloadPdf(Motor $motor)
    {
        //$snappy = PDF::loadView("motores.contrasenia",['motor'=>$motor]);
        $html = view('motores.contrasenia', compact('motor'))
        ->render();
    $pdf = PDF::loadHTML($html)->setOption('load-error-handling', 'ignore') // Ignora los errores de carga
    ->setOption('enable-local-file-access', true)
    ->setOption('no-stop-slow-scripts', true)
    ->setOption('javascript-delay', 5000);
    return $pdf->inline('Contrasenia.pdf');
      // return $snappy->inline();
        //$snappy = PDF::load("motores.contrasenia",$motor);
       // return $snappy->stream();
        //return $pdf->download('contrasenia.pdf');
       // return PDF::loadView("motores.contrasenia",['server'=>'http://http://45.188.128.210/','motor'=>$motor])->inline();
       // return view("motores.contrasenia",['server'=>'http://192.168.0.130/','motor'=>$motor]);
    

      
   
    }
}
