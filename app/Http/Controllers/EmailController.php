<?php

namespace App\Http\Controllers;

/*use Illuminate\Http\Request;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        Mail::to($request->email)->send(new TestMail('張育誠'));

        return response()->json(['message' => 'Email sent successfully']);
    }
}*/
use App\Models\EmailJob;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        //dd($request->all());

        EmailJob::create([
            'email' => $request->email,
            'sender' => $request->sender,
        ]);

        return response()->json(['message' => 'Email job created successfully']);
    }
}
