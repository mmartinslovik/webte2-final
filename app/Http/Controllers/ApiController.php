<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

class ApiController extends Controller
{
    public function getCoordinatesResponse(Request $request) {
        header("HTTP/1.1 200 SUCCESS");
        $jsonResult = new stdClass();
        $jsonList = [];
        $output = [];
        $api_key = $request->input('api_key');
        $r = $request->input('r');

        if (isset($api_key) and $api_key != env("API_KEY")) {
            header("HTTP/1.1 401 UNAUTHORIZED");
            exit();
        }

        if (isset($r)) {
            $cmd = 'octave -qf --eval " try m1 = 2500; m2 = 320;k1 = 80000; k2 = 500000;b1 = 350; b2 = 15020; A=[0 1 0 0;-(b1*b2)/(m1*m2) 0 ((b1/m1)*((b1/m1)+(b1/m2)+(b2/m2)))-(k1/m1) -(b1/m1);b2/m2 0 -((b1/m1)+(b1/m2)+(b2/m2)) 1;k2/m2 0 -((k1/m1)+(k1/m2)+(k2/m2)) 0]; B=[0 0;1/m1 (b1*b2)/(m1*m2);0 -(b2/m2);(1/m1)+(1/m2) -(k2/m2)]; C=[0 0 1 0]; D=[0 0]; Aa = [[A,[0;0;0;0]];[C, 0]]; Ba = [B;[0 0]];Ca = [C,0]; Da = D;K = [0 2.3e6 5e8 0 8e6];pkg load control;sys = ss(Aa-Ba(:,1)*K,Ba,Ca,Da);t = 0:0.01:5;r = ' . $r . ';initX1=0; initX1d=0;initX2=0; initX2d=0;[y,t,x]=lsim(sys*[0;1],r*ones(size(t)),t,[initX1;initX1d;initX2;initX2d;0]); [x(:,1),x(:,3)] catch err=lasterror.message; end_try_catch; err"';
            exec($cmd, $output);
            if (count($output) == 1) {
                header("HTTP/1.1 400 BAD REQUEST");
                $jsonObject = new stdClass();
                $jsonObject->err = substr($output[0], 6);
                $jsonList[] = $jsonObject;
            } else {
                $counter = 0;
                foreach ($output as $value) {
                    if ($counter > 1) {
                        $parsedString = substr($value, 3);
                        $x1 = floatval(substr($parsedString, 0, 7));
                        $x3 = floatval(substr($parsedString, 8));
                        $jsonObject = new stdClass();
                        $jsonObject->x1 = $x1;
                        $jsonObject->x3 = $x3;
                        $jsonList[] = $jsonObject;
                    }
                    $counter++;
                }
            }
            $jsonResult->result = $jsonList;
            echo json_encode($jsonResult);
        } else {
            header("HTTP/1.1 404 NOT FOUND");
        }
    }

    public function getCommandResponse(Request $request) {
        header("HTTP/1.1 200 SUCCESS");
        $jsonResult = new stdClass();
        $jsonList = [];
        $output = [];
        $api_key = $request->input('api_key');
        $command = $request->input('command');

        if (isset($api_key) and $api_key != env("API_KEY")) {
            header("HTTP/1.1 401 UNAUTHORIZED");
            exit();
        }

        if (isset($command)) {
            $cmd = 'octave -qf --eval "try pkg load control;' . $command . ' catch err=lasterror.message; end_try_catch; err"';
            exec($cmd, $output);
            if (str_starts_with($output[0], "err")) {
                header("HTTP/1.1 400 BAD REQUEST");
                $jsonObject = new stdClass();
                $jsonObject->err = substr($output[0], 7);
                $jsonList[] = $jsonObject;
            } else {
                foreach ($output as $value) {
                    $jsonObject = new stdClass();
                    $jsonObject->ans = $value;
                    $jsonList[] = $jsonObject;
                }
            }
            $jsonResult->result = $jsonList;
            echo json_encode($jsonResult);
        } else {
            header("HTTP/1.1 404 NOT FOUND");
        }
    }
}
