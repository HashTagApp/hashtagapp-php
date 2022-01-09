<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {


        print_r($request->all());
        $this->validate($request, [
            'name' => 'required',
            'password' => ['required',
                'string', // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'],
            'cpassword' => 'required|same:password',
            'email' => 'required|email',

        ]);

        try {

            $requestPassword=$request->get('password');
            $password = md5($requestPassword);


            $response = Http::post('http://localhost:8080/v1/App/registration-page', [
                'username' => $request->get('name'),
                'password' => $password,
                'email' =>    $request->get('email'),
            ]);


            $response->getStatusCode();
            $response->getHeader('content-type');

            if ($response->getStatusCode() == 201) {

                $err = (string)$response->getBody();

                return redirect('/register')->with('ErrorMessages', $err);

            } elseif ($response->getStatusCode() == 404) {

                return redirect('/error404')->with('ErrorMessages');

            }elseif ($response->getStatusCode() == 200){

                return redirect('/')->with('status','Congratulations, your account
has been successfully created');

            }

        }catch (Exception $response){

            return redirect('/register')->with('Try Aging', $err);

    }

    }
}
