<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function show() {
    
    $status = \DB::table('status')->orderBy('rank', 'asc')->get();
    $info = \DB::table('info')->latest('created_at')->take(10)->get();

        return view('status', ['status' => $status], ['info' => $info]);
    }
}
