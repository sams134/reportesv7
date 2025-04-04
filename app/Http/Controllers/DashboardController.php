<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __invoke()
    {
        
        switch (auth()->user()->userType) {
           case '1':
            return view('dashboard')->with('user', auth()->user());
               break;
            case '2':
            default:
                return redirect()->route('motores.index');
                break;
           
        }
        
    }
}
