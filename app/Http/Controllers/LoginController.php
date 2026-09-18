<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        if (Auth::guard('siswa')->check()) {
            return view('home.dashboardSiswa');
        } else if (Auth::guard('guru')->check()) {
            return view('home.dashboardGuru');
        } else if (Auth::guard('kelas')->check()) {
            return view('home.dashboardAdmin');
        } else if (Auth::check()) {
            return view('home.dashboardAdmin');
        }  else {
            return view('auth.login');
        }
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        } else if (Auth::guard('siswa')->attempt($credentials)) {
            return redirect()->intended('dashboard');
        } else if (Auth::guard('guru')->attempt($credentials)) {
            return redirect()->intended('dashboard');
        } else if (Auth::guard('kelas')->attempt($credentials)) {
            return redirect()->intended('dashboard');
        } else {
            return redirect()->back()->with('warning', 'Username atau Password salah!')->withInput($request->only('username'));
        }
    }

    public function signOut()
    {
        Auth::guard('siswa')->logout();
        Auth::guard('guru')->logout();
        Auth::guard('kelas')->logout();
        Auth::logout();
        return redirect('/');
    }
}
