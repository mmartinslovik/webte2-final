<?php

namespace App\Http\Controllers;

use App\Models\Cas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CasController extends Controller
{
    public function getCas(Request $request)
    {
        $command = $request->input('command');

        $casResponse = Http::get('https://site162.webte.fei.stuba.sk/octave/command.php', [
            'command' => $command,
            'api_key' => '27925e7e-a476-4a0d-a2a8-ee84d29dc364'
        ]);

        $result = json_decode($casResponse);

        $cas = new Cas();
        $cas->command = $command;
        $cas->execution_time = date('Y-m-d H:i:s');

        if(isset($result->result[0]->err)) {
            $cas->error_occurred = $result->result[0]->err;
        }

        $cas->save();

        return view('cas')->with(
            [
                'result' => $result
            ]
        );
    }

    // TODO cas with r and plot function
}
