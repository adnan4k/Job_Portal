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
            if(auth()->user()->user_type == 'employer'){
                return redirect('dashboard');
            }else{
                return redirect()->to('/');
            }
        }

        return 'something went wrong';
    }

    public function logout(){

        auth()->logout();
        return redirect('login');
    }

    public function profile(){

        return view('profile.index');
    }

    public function seekerProfile(){

        return view('seeker.profile');
    }
    public function update(Request $request){
        if($request->hasFile('profile_pic')){
            $imagePath = $request->file('profile_pic')->store('images', 'public');
            User::find(auth()->user()->id)->update(['profile_pic',$imagePath]);
        }

        User::find(auth()->user()->id)->update($request->except('profile_pic'));

        return redirect('profile.index')->with('success','Your job is successfully update');

    }
}