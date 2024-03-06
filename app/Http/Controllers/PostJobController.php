<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditFormRequest;
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

    public function edit(Listing $listing){

        return view('job.edit',compact('listing'));
    }

    public function update($id,EditFormRequest $request){
        if($request->hasFile('feature_image')){
            $imagePath = $request->file('feature_image')->store('images', 'public');
            Listing::find($id)->update(['feature_image',$imagePath]);
        }

        Listing::find($id)->update($request->except('feature_image'));

        return redirect('job.index')->with('success','Your job is successfully update');
    }

    public function index(){
        $jobs = Listing::where('user_id',auth()->user()->id)->get();
        // dd($jobs);
        return view('job.index',compact('jobs'));
    }

    public function destroy($id){

         if(!$id){
            return back()-with('success','The give id donot exist');
        }
        Listing::find($id)->delete();

        return back()-with('success','The job has been deleted successfully');
    }
}
