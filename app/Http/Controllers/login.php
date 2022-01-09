<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user_registation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Cache;

class login extends Controller
{
    //
    public function index()
    {
        $Re =session()->get('LoggedUser');
        $loginTrue =session()->get('loginTrue');


        if($Re == "" && $loginTrue == ""){
            return view('login');

        }else{
            $cap = array('username' =>$Re );
            return view('home') ->with($cap);

        }





    }

    function checklogin(Request $request)
    {

        print_r($request->all());
        $this->validate($request, [
            'password' => ['required',
                'string', // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'],
            'email' => 'required|email',

        ]);

        $requestPassword=$request->get('password');
        $email=$request->get('email');
        $password = md5($requestPassword);


            $response = Http::post('http://localhost:8080/v1/App/login', [
                'password' => $password,
                'email' =>    $email,
            ]);

        $json =$response->getBody();

        $json = json_decode($json, true);


        $err =$json['error'];


        if($err == null)
        {
            $msg= $json['message'];
            $username =$json['username'];
            $status =$json['status'];


            if ($response->status() == 200) {

                if ($msg != "" && $username != "") {

                    session()->put('LoggedUser',$username );
                    session()->put('status',$status );
                    session()->put('loginTrue','ok' );

                    return redirect('/welcome')->with('status', 'Congratulations, your account');

                } else {

                    return redirect('/')->with('ErrorMessages', $msg);
                }


            }

            }else{

            return redirect('/')->with('ErrorMessages', $err);

        }

            if (empty($countryCode)) {
                $response->getBody();
            }




    }

    function successlogin()
    {
        $Re =session()->get('LoggedUser');
        if($Re == ""){
            return redirect('/')->with('ErrorMessages', 'Session Timeout');
        }else{

            $cap = array('username' =>$Re );
            return view('home') ->with($cap);

        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('main');
    }




}
