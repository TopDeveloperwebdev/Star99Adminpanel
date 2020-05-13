<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class ChangeCurrentEmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function showChangeEmailForm(){
        return view('auth.changeemail');
    }

    public function changeEmail(Request $request){

        if (!(($request->get('current-email')))) {
            // The emails matches
            return redirect()->back()->with("error","Your current email does not matches with the email you provided. Please try again.");
        }

        if(strcmp($request->get('current-email'), $request->get('new-email')) == 0){
            //Current email and new email are same
            return redirect()->back()->with("error","New email cannot be same as your current email. Please choose a different email.");
        }

        if (User::where('email',$request->get('new-email')) -> first()) {
          // user found
          return redirect()->back()->with("error","Email already exists.");
       }

        $validatedData = $request->validate([
            'current-email' => 'required',
            'new-email' => 'required|email|min:1|confirmed',
        ]);

        //Change email
        $user = Auth::user();
        $user->email = ($request->get('new-email'));
        $user->save();

        return redirect()->back()->with("success","Email changed successfully !");

    }
}
