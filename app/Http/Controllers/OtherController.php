<?php

namespace App\Http\Controllers;

use App\Models\career;

use App\Models\contacts;
use App\Models\galleries;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OtherController extends Controller
{
    public function viewCareerPage()
    {
        return view('/career');
    }

    public function storeCareerApplication(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email'],
            'message' => ['required'],
            'file' => ['required', 'mimes:pdf', 'max:3000'],
        ]);

        // Handle file upload and store it
        $file = $request->file('file');
        $fileName = time() . '.' . $file->extension();
        $file->move(public_path('career_files'), $fileName);

        // Create a new CareerApplication instance and save it to the database
        $careerApplication = new career;
        $careerApplication->name = $request->name;
        $careerApplication->email = $request->email;
        $careerApplication->message = $request->message;
        $careerApplication->file = $fileName; // Store the file name in the 'resume' column

        $careerApplication->save();

        return back()->withSuccess('Application Submitted');
    }

    public function blogPage()
    {
        return view('blogpage');
    }

    // contact us related controller

    public function contact()
    {
        return view('contact_us');
    }

    public function submitcontact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'subject' => ['required'],
            'message' => ['required'],

        ]);

        $contactfiled = new contacts;
        $contactfiled->name = $request->name;
        $contactfiled->email = $request->email;
        $contactfiled->phone = $request->phone;
        $contactfiled->subject = $request->subject;
        $contactfiled->message = $request->message;

        $contactfiled->save();


        return back()->withSuccess('Submitted');
    }

    public function viewGallery()
    {
        $users = galleries::all();
        return view('gallery')->with('users', $users);
    }
}
