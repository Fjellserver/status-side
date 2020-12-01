<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Updater extends Controller
{
    public function hostSubmit(Request $request) {
        \DB::table('hosts')->insert(
            ['name' => $request->host, 'ip' => $request->ip]
        );

        return redirect()->to('/');
    }

    public function hosts() {
        $hosts = \DB::table('hosts')->get();
        return view('dashboard', ['hosts' => $hosts]);
    }

    public function removehost($id) {
        \DB::table('hosts')->where('id', '=', $id)->delete();
        return redirect()->back();
    }
}
