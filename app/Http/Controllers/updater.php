<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class updater extends Controller
{
    public function formSubmit(Request $request) {
        \DB::table('hosts')->insert(
            ['name' => $request->host, 'ip' => $request->ip]
        );

        return redirect()->to('/');
    }
}
