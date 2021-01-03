<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Updater extends Controller
{
    public function hostSubmit(Request $request) {
        \DB::table('hosts')->insert(
            ['name' => $request->host, 'ip' => $request->ip]
        );

        return redirect()->back();
    }

    public function main() {
        $hosts = \DB::table('hosts')->get();
        $info = \DB::table('info')->latest('created_at')->get();
        return view('dashboard', ['hosts' => $hosts, 'info' => $info]);
    }

    public function removehost($hostid) {
        \DB::table('hosts')->where('id', '=', $hostid)->delete();
        return redirect()->back();
    }

    public function removeinfo($infoid) {
        \DB::table('info')->where('id', '=', $infoid)->delete();
        return redirect()->back();
    }
}
