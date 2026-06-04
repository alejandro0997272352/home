<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $request->user()->markEmailAsVerified();
        return redirect()->intended('/dashboard')->with('success', 'Email verificado correctamente.');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Enlace de verificación enviado.');
    }
}
