<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientAuthController extends Controller
{
    public function showRegister()
    {
        return view('patient.register');
    }

    public function sendOtp(Request $req)
    {
        $req->validate(['phone'=>'required']);

        $code = rand(100000,999999);
        cache()->put('otp_'.$req->phone, $code, now()->addMinutes(5));

        return back()->with('success','OTP dikirim');
    }
}