<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        } else if (Auth::guard('web')->check() || Auth::check()) {
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
                return redirect()->intended('/dashboard');
            }
        } catch (\Throwable $e) {}

        // 2. Try Guru Guard (guru table: username, email, or nip_nuptk)
        try {
            if (Auth::guard('guru')->attempt(['username' => $loginInput, 'password' => $password]) ||
                Auth::guard('guru')->attempt(['email' => $loginInput, 'password' => $password]) ||
                Auth::guard('guru')->attempt(['nip_nuptk' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }
        } catch (\Throwable $e) {}

        // 3. Try Siswa Guard (siswa table: username, email, or nisn)
        try {
            if (Auth::guard('siswa')->attempt(['username' => $loginInput, 'password' => $password]) ||
                Auth::guard('siswa')->attempt(['email' => $loginInput, 'password' => $password]) ||
                Auth::guard('siswa')->attempt(['nisn' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }
        } catch (\Throwable $e) {}

        // 4. Try Kelas Guard (kelas table: username)
        try {
            if (Auth::guard('kelas')->attempt(['username' => $loginInput, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->route('viewAbsensiSiswa');
            }
        } catch (\Throwable $e) {}

        // 5. Fallback for legacy plain text / MD5 passwords
        try {
            $guru = DB::table('guru')->where('username', $loginInput)->orWhere('email', $loginInput)->first();
            if ($guru && !empty($guru->password) && ($guru->password === $password || md5($password) === $guru->password)) {
                DB::table('guru')->where('kode_guru', $guru->kode_guru)->update(['password' => bcrypt($password)]);
                Auth::guard('guru')->loginUsingId($guru->kode_guru);
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            $siswa = DB::table('siswa')->where('username', $loginInput)->orWhere('nisn', $loginInput)->first();
            if ($siswa && !empty($siswa->password) && ($siswa->password === $password || md5($password) === $siswa->password)) {
                DB::table('siswa')->where('kode_siswa', $siswa->kode_siswa)->update(['password' => bcrypt($password)]);
                Auth::guard('siswa')->loginUsingId($siswa->kode_siswa);
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            $kelas = DB::table('kelas')->where('username', $loginInput)->first();
            if ($kelas && !empty($kelas->password) && ($kelas->password === $password || md5($password) === $kelas->password)) {
                DB::table('kelas')->where('kode_kelas', $kelas->kode_kelas)->update(['password' => bcrypt($password)]);
                Auth::guard('kelas')->loginUsingId($kelas->kode_kelas);
                $request->session()->regenerate();
                return redirect()->route('viewAbsensiSiswa');
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
            } else if (Auth::guard('kelas')->check()) {
                DB::table('kelas')
                ->where('kode_kelas', Auth::guard('kelas')->user()->kode_kelas)
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
                ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
                ->update([
                    'username' => $email,
                ]);
            } else if (Auth::guard('kelas')->check()) {
                DB::table('kelas')
                ->where('kode_kelas', Auth::guard('kelas')->user()->kode_kelas)
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
