<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function formSubmit(Request $request) 
    {
       // dd($request->all());
        \DB::table('info')->insert(
            ['navn' => $request->navn, 'beskrivelse' => $request->beskrivelse]
        );
    }
}
