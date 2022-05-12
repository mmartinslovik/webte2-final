<?php

namespace App\Http\Controllers;

use App\Models\Cas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use stdClass;

class CasController extends Controller
{
    public function getCas(Request $request)
    {
        $command = $request->input('command');

        $casResponse = Http::get('http://localhost:3001/command', [
            'command' => $command,
            'api_key' => env('API_KEY')
        ]);

        $result = json_decode($casResponse);

        $cas = new Cas();
        $cas->command = $command;
        $cas->execution_time = date('Y-m-d H:i:s');

        if (isset($result->result[0]->err)) {
            $cas->error_occurred = $result->result[0]->err;
        }

        $cas->save();

        return view('cas')->with(
            [
                'result' => $result
            ]
        );
    }

    public function exportCsv(Request $request)
    {
        $sendEmail = $request->input('sendEmail');
        $email = $request->input('email');

        $table = Cas::all();
        $filename = 'exported_logs.csv';
        $file = fopen($filename, 'w');
        foreach ($table as $row) {
            fputcsv($file, $row->toArray());
        }
        fclose($file);

        if (isset($sendEmail)) {
            Mail::raw('Hello, this is exported database to csv.', function ($message) use ($filename, $email) {
                $message->attach($filename);
                $message->to($email);
                $message->subject("Exported csv file of API requests");
            });
        }

        return view('cas')->with(
            [
                "sent" => true
            ]
        );
    }

    // TODO cas with r and plot function
}
