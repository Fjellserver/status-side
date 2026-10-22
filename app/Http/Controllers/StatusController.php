<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatusController extends Controller
{
    public function show(): View
    {
        return view('status', [
            'status' => DB::table('status')->orderBy('rank')->get(),
            'info' => DB::table('info')->latest('created_at')->take(10)->get(),
        ]);
    }
}
