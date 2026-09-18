<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        } else if (Auth::guard('web')->check() || Auth::check()) {
            return view('home.dashboardAdmin');
        } else {
            return view('auth.login');
        }
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username atau Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $loginInput = trim($request->username);
        $password = $request->password;

        // 1. Try Web Guard (users table: email or username)
        try {
            if (Auth::guard('web')->attempt(['email' => $loginInput, 'password' => $password]) ||
                Auth::guard('web')->attempt(['username' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $e) {}

        // 2. Try Guru Guard (guru table: username, email, or nip_nuptk)
        try {
            if (Auth::guard('guru')->attempt(['username' => $loginInput, 'password' => $password]) ||
                Auth::guard('guru')->attempt(['email' => $loginInput, 'password' => $password]) ||
                Auth::guard('guru')->attempt(['nip_nuptk' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $e) {}

        // 3. Try Siswa Guard (siswa table: username, email, or nisn)
        try {
            if (Auth::guard('siswa')->attempt(['username' => $loginInput, 'password' => $password]) ||
                Auth::guard('siswa')->attempt(['email' => $loginInput, 'password' => $password]) ||
                Auth::guard('siswa')->attempt(['nisn' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $e) {}

        // 4. Try Kelas Guard (kelas table: username)
        try {
            if (Auth::guard('kelas')->attempt(['username' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $e) {}

        // 5. Fallback for legacy plain text / MD5 passwords
        try {
            $webUser = DB::table('users')->where('email', $loginInput)->orWhere('username', $loginInput)->first();
            if ($webUser && !empty($webUser->password)) {
                $isMatch = ($webUser->password === $password || 
                            md5($password) === $webUser->password || 
                            sha1($password) === $webUser->password ||
                            \Illuminate\Support\Facades\Hash::check($password, $webUser->password));
                if ($isMatch) {
                    DB::table('users')->where('id', $webUser->id)->update(['password' => bcrypt($password)]);
                    Auth::guard('web')->loginUsingId($webUser->id);
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                }
            }

            $guru = DB::table('guru')->where('username', $loginInput)->orWhere('email', $loginInput)->first();
            if ($guru && !empty($guru->password) && ($guru->password === $password || md5($password) === $guru->password)) {
                DB::table('guru')->where('kode_guru', $guru->kode_guru)->update(['password' => bcrypt($password)]);
                Auth::guard('guru')->loginUsingId($guru->kode_guru);
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            $siswa = DB::table('siswa')->where('username', $loginInput)->orWhere('nisn', $loginInput)->first();
            if ($siswa && !empty($siswa->password) && ($siswa->password === $password || md5($password) === $siswa->password)) {
                DB::table('siswa')->where('kode_siswa', $siswa->kode_siswa)->update(['password' => bcrypt($password)]);
                Auth::guard('siswa')->loginUsingId($siswa->kode_siswa);
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            $kelas = DB::table('kelas')->where('username', $loginInput)->first();
            if ($kelas && !empty($kelas->password) && ($kelas->password === $password || md5($password) === $kelas->password)) {
                DB::table('kelas')->where('kode_kelas', $kelas->kode_kelas)->update(['password' => bcrypt($password)]);
                Auth::guard('kelas')->loginUsingId($kelas->kode_kelas);
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $e) {}

        return redirect()->back()
            ->with('warning', 'Username atau Password salah!')
            ->withInput($request->only('username'));
    }

    public function signOut()
    {
        Auth::guard('siswa')->logout();
        Auth::guard('guru')->logout();
        Auth::guard('kelas')->logout();
        Auth::guard('web')->logout();
        Auth::logout();
        return redirect('/');
    }
}
