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

    public function storeSeeker(RegistrationFormRequest $request){
       
        User::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'password'=>request('password'),
            'user_type' => 'seeker'
        ]);

        return redirect('login')->with('your account was created');;
    }
    public function storeEmployer(RegistrationFormRequest $request){
       
        User::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'password'=>request('password'),
            'user_type' => 'employer',
            'user_trail' =>now()->addWeeks()
        ]);

        return redirect('login')->with('your account was created');
    }

    public function login(){

        return view('user.login');
    }

    public function postLogin(Request $request){
        
        $request->validate([
            'email'=>['required'],
            'password'=>['required'],
        ]);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended('dashboard');
        }

        return 'something went wrong';
    }

    public function logout(){

        auth()->logout();
        return redirect('login');
    }
}
