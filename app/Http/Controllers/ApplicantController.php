<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    //
    public function index(){
        $listings = Listing::withCount('users')->where('user_id',auth()->user()->id)->get();
        dd($listings);
         if($listings){
            return view('applicants.index',compact('listings'))->with('error','sorry unable to load the jobs');
         }
        return view('applicants.index',compact('listings'));
     }

     public function show(Listing $listing){

         $listings = Listing::where('users')->where('slug',$listing->slug)->first();
         return view('applicants.show',compact('listings'));
     }
}
