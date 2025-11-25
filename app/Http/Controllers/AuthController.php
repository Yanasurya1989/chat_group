<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            // set user online
            $user = Auth::user();
            $user->online = 1;
            $user->save();

            return redirect()->route('chat.index');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        $user = Auth::user();

        // set offline sebelum logout
        if ($user) {
            $user->online = 0;
            $user->save();
        }

        Auth::logout();

        return redirect()->route('login');
    }
}
