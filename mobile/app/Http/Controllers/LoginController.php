<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class LoginController extends Controller
{

    public function index()
    {
        if (Auth::guard('siswa')->check()) {
            return view('home.siswa');
        } else if (Auth::guard('guru')->check()) {
            return view('home.guru');
        } else if (Auth::guard('kelas')->check()) {
            return view('home.admin');
        } else if (Auth::check()) {
            return view('home.admin');
        } else {
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
    public function settings()
    {
        return view('settings.setting');
    }
    public function updatePassword(Request $request)
    {
        $password = bcrypt($request->input('password'));
        DB::transaction(function () use ($password) {

            if (Auth::guard('siswa')->check()) {
                DB::table('siswa')
                ->where('kode_siswa', Auth::guard('siswa')->user()->kode_siswa)
                ->update([
                    'password' => $password,
                ]);
            } else if (Auth::guard('guru')->check()) {
                DB::table('guru')
                ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
                ->update([
                    'password' => $password,
                ]);
            } else {
                DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'password' => $password,
                ]);
            }
        });

    }

    public function updateEmail(Request $request)
    {
        $email = $request->input('email');

        DB::transaction(function () use ($email) {

            if (Auth::guard('siswa')->check()) {
                DB::table('siswa')
                ->where('kode_siswa', Auth::guard('siswa')->user()->kode_siswa)
                ->update([
                    'username' => $email,
                ]);
            } else if (Auth::guard('guru')->check()) {
                DB::table('guru')
                ->where('kode_guru', Auth::guard('siswa')->user()->kode_guru)
                ->update([
                    'username' => $email,
                ]);
            } else {
                DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'username' => $email,
                ]);
            }
        });

    }
}
