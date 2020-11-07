<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function show() {

    $status = \DB::table('status')->latest('last_checked')->take(4)->get();
    $info = \DB::table('info')->latest('DateCreated')->take(4)->get();

    //dd($info);
        return view('status', ['status' => $status], ['info' => $info]);
    }
}
