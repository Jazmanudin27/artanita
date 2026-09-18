<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    private function hasCol($table, $column) {
        return Cache::remember("col_{$table}_{$column}", 86400, function() use ($table, $column) {
            return Schema::hasTable($table) && Schema::hasColumn($table, $column);
        });
    }

    private function hasTbl($table) {
        return Cache::remember("tbl_{$table}", 86400, function() use ($table) {
            return Schema::hasTable($table);
        });
    }

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
        $password = trim($request->password);
        $rawPassword = $request->password;

        // 1. Try Users Table (web guard)
        try {
            if ($this->hasTbl('users')) {
                $user = \App\Models\User::where(function($q) use ($loginInput) {
                    $q->where('email', $loginInput)
                      ->orWhereRaw("LOWER(TRIM(email)) = ?", [strtolower($loginInput)]);
                    if ($this->hasCol('users', 'username')) {
                        $q->orWhere('username', $loginInput)
                          ->orWhereRaw("LOWER(TRIM(username)) = ?", [strtolower($loginInput)]);
                    }
                    if ($this->hasCol('users', 'name')) {
                        $q->orWhere('name', $loginInput);
                    }
                })->first();

                if ($user && !empty($user->password)) {
                    $dbPass = $user->password;
                    $isMatch = ($dbPass === $rawPassword ||
                                $dbPass === $password ||
                                md5($rawPassword) === $dbPass ||
                                md5($password) === $dbPass ||
                                sha1($rawPassword) === $dbPass ||
                                sha1($password) === $dbPass ||
                                Hash::check($rawPassword, $dbPass) ||
                                Hash::check($password, $dbPass));

                    if ($isMatch) {
                        try {
                            $user->password = Hash::make($password);
                            $user->save();
                        } catch (\Throwable $e) {}

                        Auth::guard('web')->login($user, true);
                        Auth::login($user, true);
                        $request->session()->regenerate();
                        return redirect()->intended('dashboard');
                    }
                }
            }
        } catch (\Throwable $e) {}

        // 2. Try Guru Table (guru guard)
        try {
            if ($this->hasTbl('guru')) {
                $guru = \App\Models\Guru::where(function($q) use ($loginInput) {
                    if ($this->hasCol('guru', 'email')) {
                        $q->where('email', $loginInput)
                          ->orWhereRaw("LOWER(TRIM(email)) = ?", [strtolower($loginInput)]);
                    }
                    if ($this->hasCol('guru', 'username')) {
                        $q->orWhere('username', $loginInput)
                          ->orWhereRaw("LOWER(TRIM(username)) = ?", [strtolower($loginInput)]);
                    }
                    if ($this->hasCol('guru', 'nip_nuptk')) {
                        $q->orWhere('nip_nuptk', $loginInput);
                    }
                })->first();

                if ($guru && !empty($guru->password)) {
                    $dbPass = $guru->password;
                    $isMatch = ($dbPass === $rawPassword ||
                                $dbPass === $password ||
                                md5($rawPassword) === $dbPass ||
                                md5($password) === $dbPass ||
                                sha1($rawPassword) === $dbPass ||
                                sha1($password) === $dbPass ||
                                Hash::check($rawPassword, $dbPass) ||
                                Hash::check($password, $dbPass));

                    if ($isMatch) {
                        try {
                            $guru->password = Hash::make($password);
                            $guru->save();
                        } catch (\Throwable $e) {}

                        Auth::guard('guru')->login($guru, true);
                        $request->session()->regenerate();
                        return redirect()->intended('dashboard');
                    }
                }
            }
        } catch (\Throwable $e) {}

        // 3. Try Siswa Table (siswa guard)
        try {
            if ($this->hasTbl('siswa')) {
                $siswa = \App\Models\Siswa::where(function($q) use ($loginInput) {
                    if ($this->hasCol('siswa', 'nisn')) {
                        $q->where('nisn', $loginInput);
                    }
                    if ($this->hasCol('siswa', 'username')) {
                        $q->orWhere('username', $loginInput)
                          ->orWhereRaw("LOWER(TRIM(username)) = ?", [strtolower($loginInput)]);
                    }
                    if ($this->hasCol('siswa', 'email')) {
                        $q->orWhere('email', $loginInput)
                          ->orWhereRaw("LOWER(TRIM(email)) = ?", [strtolower($loginInput)]);
                    }
                })->first();

                if ($siswa && !empty($siswa->password)) {
                    $dbPass = $siswa->password;
                    $isMatch = ($dbPass === $rawPassword ||
                                $dbPass === $password ||
                                md5($rawPassword) === $dbPass ||
                                md5($password) === $dbPass ||
                                sha1($rawPassword) === $dbPass ||
                                sha1($password) === $dbPass ||
                                Hash::check($rawPassword, $dbPass) ||
                                Hash::check($password, $dbPass));

                    if ($isMatch) {
                        try {
                            $siswa->password = Hash::make($password);
                            $siswa->save();
                        } catch (\Throwable $e) {}

                        Auth::guard('siswa')->login($siswa, true);
                        $request->session()->regenerate();
                        return redirect()->intended('dashboard');
                    }
                }
            }
        } catch (\Throwable $e) {}

        // 4. Try Kelas Table (kelas guard)
        try {
            if ($this->hasTbl('kelas')) {
                $kelas = \App\Models\Kelas::where(function($q) use ($loginInput) {
                    if ($this->hasCol('kelas', 'username')) {
                        $q->where('username', $loginInput)
                          ->orWhereRaw("LOWER(TRIM(username)) = ?", [strtolower($loginInput)]);
                    }
                })->first();

                if ($kelas && !empty($kelas->password)) {
                    $dbPass = $kelas->password;
                    $isMatch = ($dbPass === $rawPassword ||
                                $dbPass === $password ||
                                md5($rawPassword) === $dbPass ||
                                md5($password) === $dbPass ||
                                sha1($rawPassword) === $dbPass ||
                                sha1($password) === $dbPass ||
                                Hash::check($rawPassword, $dbPass) ||
                                Hash::check($password, $dbPass));

                    if ($isMatch) {
                        try {
                            $kelas->password = Hash::make($password);
                            $kelas->save();
                        } catch (\Throwable $e) {}

                        Auth::guard('kelas')->login($kelas, true);
                        $request->session()->regenerate();
                        return redirect()->intended('dashboard');
                    }
                }
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
