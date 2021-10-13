<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Updater extends Controller
{
    public function hostSubmit(Request $request) {

        $request->validate([
            'host' => 'required',
            'ip' => 'required',
            'port' => 'required',
            'rank' => 'required',
        ]);

        \DB::table('hosts')->insert(
            ['name' => $request->host, 'ip' => $request->ip, 'port' => $request->port, 'rank' => $request->rank]
        );

        return redirect()->back();
    }

    public function main() {
        $hosts = \DB::table('hosts')->get();
        $info = \DB::table('info')->latest('created_at')->get();
        return view('dashboard', ['hosts' => $hosts, 'info' => $info]);
    }

    public function removehost($rank) {
        \DB::table('hosts')->where('rank', '=', $rank)->delete();
        \DB::table('status')->where('rank', '=', $rank)->delete();
        return redirect()->back();
    }

    public function removeinfo($infoid) {
        \DB::table('info')->where('id', '=', $infoid)->delete();
        return redirect()->back();
    }

    public function hostEditShow() {
        $input = \Input::get('host');
        $host = \DB::table('hosts')->where('id', $input)->get();
        return view('hostedit', ['host' => $host]);
    }

    public function hostEdit(Request $request) {
        $request->validate([
            'host' => 'required',
            'ip' => 'required',
        ]);
        \DB::table('hosts')->where('id', $request->id)->update   
        (
            ['name' => $request->host, 'ip' => $request->ip, 'port' => $request->port, 'rank' => $request->rank]
        );

        return redirect()->route('dashboard');
    }
}
