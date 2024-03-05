<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostJobController extends Controller
{
    //

    public function create()
    {

        return view('job.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'feature_image' => 'required',
            'description' => 'required',
            'roles' => 'required',
            'job_type' => 'required',
            'address' => 'required',
            'date' => 'required',
        ]);

        $imagePath = $request->file('feature_image')->store('images', 'public');
        $posting = new Listing();
        $posting->user_id = auth()->user()->id;
        //  dd($request->salary,'salayr');
        $posting->salary = $request->salary;
        $posting->title = $request->title;
        $posting->feature_image = $imagePath;
        $posting->description = $request->description;
        $posting->roles = $request->roles;
        $posting->job_type = $request->job_type;
        $posting->address = $request->address;
        $posting->address = $request->address;

        $dateInput = $request->date;

        $parsedDate = Carbon::parse($dateInput);

        $formattedDate = $parsedDate->format('Y-m-d');

        $posting->application_close_date = $formattedDate;

        $posting->slug = Str::slug($request->title) . '.' . Str::uuid();
        $posting->save();

        return back();
    }
}
