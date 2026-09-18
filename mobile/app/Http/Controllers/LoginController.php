<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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

        // 1. Try Web Guard (users table)
        try {
            if (Schema::hasTable('users')) {
                if (Auth::guard('web')->attempt(['email' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
                if (Schema::hasColumn('users', 'username') && Auth::guard('web')->attempt(['username' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
            }
        } catch (\Throwable $e) {}

        // 2. Try Guru Guard (guru table)
        try {
            if (Schema::hasTable('guru')) {
                if (Schema::hasColumn('guru', 'email') && Auth::guard('guru')->attempt(['email' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
                if (Schema::hasColumn('guru', 'username') && Auth::guard('guru')->attempt(['username' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
                if (Schema::hasColumn('guru', 'nip_nuptk') && Auth::guard('guru')->attempt(['nip_nuptk' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
            }
        } catch (\Throwable $e) {}

        // 3. Try Siswa Guard (siswa table)
        try {
            if (Schema::hasTable('siswa')) {
                if (Schema::hasColumn('siswa', 'nisn') && Auth::guard('siswa')->attempt(['nisn' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
                if (Schema::hasColumn('siswa', 'username') && Auth::guard('siswa')->attempt(['username' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
                if (Schema::hasColumn('siswa', 'email') && Auth::guard('siswa')->attempt(['email' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
            }
        } catch (\Throwable $e) {}

        // 4. Try Kelas Guard (kelas table)
        try {
            if (Schema::hasTable('kelas')) {
                if (Schema::hasColumn('kelas', 'username') && Auth::guard('kelas')->attempt(['username' => $loginInput, 'password' => $password])) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
            }
        } catch (\Throwable $e) {}

        // 5. Fallback for legacy plain text / MD5 / SHA1 passwords across tables
        try {
            // Check users table
            if (Schema::hasTable('users')) {
                $userQuery = DB::table('users')->where('email', $loginInput);
                if (Schema::hasColumn('users', 'username')) {
                    $userQuery->orWhere('username', $loginInput);
                }
                $webUser = $userQuery->first();
                if ($webUser && !empty($webUser->password)) {
                    $isMatch = ($webUser->password === $password || 
                                md5($password) === $webUser->password || 
                                sha1($password) === $webUser->password ||
                                Hash::check($password, $webUser->password));
                    if ($isMatch) {
                        DB::table('users')->where('id', $webUser->id)->update(['password' => bcrypt($password)]);
                        Auth::guard('web')->loginUsingId($webUser->id);
                        $request->session()->regenerate();
                        return redirect()->intended('/dashboard');
                    }
                }
            }

            // Check guru table
            if (Schema::hasTable('guru')) {
                $guruQuery = DB::table('guru');
                $conditions = [];
                if (Schema::hasColumn('guru', 'email')) $conditions[] = 'email';
                if (Schema::hasColumn('guru', 'username')) $conditions[] = 'username';
                if (Schema::hasColumn('guru', 'nip_nuptk')) $conditions[] = 'nip_nuptk';

                if (!empty($conditions)) {
                    $guruQuery->where(function($q) use ($conditions, $loginInput) {
                        foreach ($conditions as $idx => $col) {
                            if ($idx === 0) $q->where($col, $loginInput);
                            else $q->orWhere($col, $loginInput);
                        }
                    });
                    $guru = $guruQuery->first();
                    if ($guru && !empty($guru->password)) {
                        $isMatch = ($guru->password === $password || 
                                    md5($password) === $guru->password || 
                                    sha1($password) === $guru->password ||
                                    Hash::check($password, $guru->password));
                        if ($isMatch) {
                            DB::table('guru')->where('kode_guru', $guru->kode_guru)->update(['password' => bcrypt($password)]);
                            Auth::guard('guru')->loginUsingId($guru->kode_guru);
                            $request->session()->regenerate();
                            return redirect()->intended('/dashboard');
                        }
                    }
                }
            }

            // Check siswa table
            if (Schema::hasTable('siswa')) {
                $siswaQuery = DB::table('siswa');
                $conditions = [];
                if (Schema::hasColumn('siswa', 'nisn')) $conditions[] = 'nisn';
                if (Schema::hasColumn('siswa', 'username')) $conditions[] = 'username';
                if (Schema::hasColumn('siswa', 'email')) $conditions[] = 'email';

                if (!empty($conditions)) {
                    $siswaQuery->where(function($q) use ($conditions, $loginInput) {
                        foreach ($conditions as $idx => $col) {
                            if ($idx === 0) $q->where($col, $loginInput);
                            else $q->orWhere($col, $loginInput);
                        }
                    });
                    $siswa = $siswaQuery->first();
                    if ($siswa && !empty($siswa->password)) {
                        $isMatch = ($siswa->password === $password || 
                                    md5($password) === $siswa->password || 
                                    sha1($password) === $siswa->password ||
                                    Hash::check($password, $siswa->password));
                        if ($isMatch) {
                            DB::table('siswa')->where('kode_siswa', $siswa->kode_siswa)->update(['password' => bcrypt($password)]);
                            Auth::guard('siswa')->loginUsingId($siswa->kode_siswa);
                            $request->session()->regenerate();
                            return redirect()->intended('/dashboard');
                        }
                    }
                }
            }

            // Check kelas table
            if (Schema::hasTable('kelas') && Schema::hasColumn('kelas', 'username')) {
                $kelas = DB::table('kelas')->where('username', $loginInput)->first();
                if ($kelas && !empty($kelas->password)) {
                    $isMatch = ($kelas->password === $password || 
                                md5($password) === $kelas->password || 
                                sha1($password) === $kelas->password ||
                                Hash::check($password, $kelas->password));
                    if ($isMatch) {
                        DB::table('kelas')->where('kode_kelas', $kelas->kode_kelas)->update(['password' => bcrypt($password)]);
                        Auth::guard('kelas')->loginUsingId($kelas->kode_kelas);
                        $request->session()->regenerate();
                        return redirect()->intended('/dashboard');
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
