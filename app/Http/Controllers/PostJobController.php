<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostJobController extends Controller
{
    //

    public function create(){

        return view('job.create');
        
    }

    public function store(Request $request){

         $this->validate($request,[
            'title' =>'required',
            'feature_image' =>'required',
            'description' =>'required',
            'roles' =>'required',
            'job_type' =>'required',
            'address' =>'required',
            'date' =>'required',
         ]);
    }
}
