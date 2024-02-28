<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createSeeker(){

        return view('user.register-seeker');
    }
    public function createEmployer(){

        return view('user.register-employer');
    }

    public function storeSeeker(RegistrationFormRequest $request)
    {
         User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'user_type' => 'seeker',
        ]);
    
      
    }
    
    public function storeEmployer(RegistrationFormRequest $request){
       
       User::create([
            'name'=> $request->input('name'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'user_type' =>'employer',
            'user_trail' =>now()->addWeeks()
        ]);

        return redirect('login')->with('your account was created');
    }

    public function login(){

        return view('user.login');
    }

    public function postLogin(Request $request){
        
        $request->validate([
            'email' => ['required', 'email', 'max:255', ],
            'password'=>['required'],
        ]);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect('dashboard');
        }

        return 'something went wrong';
    }

    public function logout(){

        auth()->logout();
        return redirect('login');
    }
}
