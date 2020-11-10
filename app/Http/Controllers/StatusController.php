<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function show() {
    
    $hosts = \DB::table('hosts')->get();
    $count = $hosts->count();
    $status = \DB::table('status')->latest('created_at')->take($count)->get();
    $info = \DB::table('info')->latest('created_at')->take(4)->get();

    //dd($status);
        return view('status', ['status' => $status], ['info' => $info]);
    }
}
