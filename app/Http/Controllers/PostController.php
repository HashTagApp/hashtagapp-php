<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function index()
    {
        return view('register');
    }
    public function store(Request $request)
    {

        print_r($request->all());
        $this->validate($request,[
            'name'=>'required',
            'password'=> [ 'required',
                'string',
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'],
            'cpassword'=>'required|same:password',
            'email'=>'required|email',

        ]);


        $res = Http::retry(5,100) ->get('localhost:8080/v1/ping');
        $res->json();


        return redirect('/')->with('status', 'Blog Post Form Data Has Been inserted');
    }

}
