<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function changePassword(Request $request){
        $request->validate([
            'password' =>'required',
            'current_password' =>'required|confirmed',

        ]);

        $user = auth()->user();
        if(!Hash::check($request->current_password,$user->password)){
            return back()->with('error','Your current password is incorrect');
        }
        $user->passord = Hash::make($request->password);
        $user->save();

        return back()->with('success','Your password is updated successfully');

    }

    public function uploadResume(Request $request){
           $request->validate([
            'resume'=>'required'
           ]);
        //  dd($request->resume);
        if($request->hasFile('resume')){
            $resume = $request->file('resume')->store('resume', 'public');
            User::find(auth()->user()->id)->update(['resume',$resume]);
            return back()->with('success','Your resume is successfully update');

        }else{
            return back()->with('error','something went wrong');
        }


    }
}