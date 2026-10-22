<?php

namespace App\Http\Controllers;

use App\Rules\HostAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class Updater extends Controller
{
    public function main(): View
    {
        return view('dashboard', [
            'hosts' => DB::table('hosts')->get(),
            'info' => DB::table('info')->latest('created_at')->get(),
            'infoone' => DB::table('info')->latest('created_at')->first(),
        ]);
    }

    public function hostSubmit(Request $request): RedirectResponse
    {
        $data = $request->validate($this->hostRules());

        DB::table('hosts')->insert([
            'name' => $data['host'],
            'ip' => $data['ip'],
            'port' => $data['port'],
            'rank' => $data['rank'],
        ]);

        return redirect()->back();
    }

    public function hostEditShow(Request $request): View
    {
        $data = $request->validate([
            'host' => ['required', 'integer'],
        ]);

        return view('hostedit', [
            'host' => DB::table('hosts')->where('id', $data['host'])->get(),
        ]);
    }

    public function hostEdit(Request $request): RedirectResponse
    {
        $data = $request->validate($this->hostRules() + [
            'id' => ['required', 'integer', 'exists:hosts,id'],
        ]);

        DB::table('hosts')->where('id', $data['id'])->update([
            'name' => $data['host'],
            'ip' => $data['ip'],
            'port' => $data['port'],
            'rank' => $data['rank'],
        ]);

        return redirect()->route('dashboard');
    }

    public function removehost(int $host): RedirectResponse
    {
        $row = DB::table('hosts')->where('id', $host)->first();

        if ($row !== null) {
            DB::table('hosts')->where('id', $row->id)->delete();
            DB::table('status')->where('host', $row->name)->delete();
        }

        return redirect()->back();
    }

    public function removeinfo(int $info): RedirectResponse
    {
        DB::table('info')->where('id', $info)->delete();

        return redirect()->back();
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function hostRules(): array
    {
        return [
            'host' => ['required', 'string', 'max:255'],
            'ip' => ['required', 'string', 'max:255', new HostAddress],
            'port' => ['required', 'integer', 'between:1,65535'],
            'rank' => ['required', 'integer', 'min:0'],
        ];
    }
}
