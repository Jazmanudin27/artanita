<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $guru = DB::table('guru')
        ->orderBy('guru.nama_guru', 'ASC')
        ->get();
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $username = $request->username ?: ($request->email ?: $request->nip_nuptk);
        $password = $request->password ?: '123456';
        $hashedPassword = bcrypt($password);
        $kodeMember = Auth::check() ? Auth::user()->kode_member : null;

        $simpan = DB::table('guru')
            ->insert([
                'no_urut' => $request->no_urut,
                'nama_guru' => $request->nama_guru,
                'username' => $username,
                'password' => $hashedPassword,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nip_nuptk' => $request->nip_nuptk,
                'status_kepegawaian' => $request->status_kepegawaian,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'tmt' => $request->tmt,
                'agama' => $request->agama,
                'email' => $request->email,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'jk' => $request->jk,
                'status' => 'Aktif',
                'kode_member' => $kodeMember,
            ]);

        // Also insert into users table if present
        if ($simpan && Schema::hasTable('users')) {
            try {
                DB::table('users')->updateOrInsert(
                    ['email' => $request->email],
                    [
                        'name' => $request->nama_guru,
                        'username' => $username,
                        'password' => $hashedPassword,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } catch (\Throwable $e) {}
        }

        if ($simpan) {
            return Redirect('viewGuru')->with(['success' => 'Data Guru Berhasil Disimpan']);
        } else {
            return Redirect('viewGuru')->with(['warning' => 'Data Guru Gagal Disimpan']);
        }
    }

    public function delete(Request $request)
    {
        $hapus = DB::table('guru')->where('kode_guru', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewGuru')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewGuru')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $guru = DB::table('guru')->where('guru.kode_guru', $id)->first();
        return view('guru.edit', compact('guru'));
    }

    public function show(Request $request)
    {
        $jk = $request->jk;
        $status = $request->status;
        $nama_guru = $request->nama_guru;

        $guru = DB::table('guru')
        ->when($status, function ($query) use ($status) {
            return $query->where('guru.status', $status);
        })
        ->when($jk, function ($query) use ($jk) {
            return $query->where('guru.jk', $jk);
        })
        ->when($nama_guru, function ($query) use ($nama_guru) {
            return $query->where('guru.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        })
        ->orderBy('guru.nama_guru')
        ->get();
        return view('guru.show', compact('guru'));
    }

    public function update(Request $request)
    {
        $dataUpdate = [
            'no_urut' => $request->no_urut,
            'nama_guru' => $request->nama_guru,
            'username' => $request->username,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nip_nuptk' => $request->nip_nuptk,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'tmt' => $request->tmt,
            'agama' => $request->agama,
            'email' => $request->email,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jk,
            'status' => $request->status,
        ];

        if (!empty($request->password)) {
            $dataUpdate['password'] = bcrypt($request->password);
        }

        $update = DB::table('guru')
            ->where('kode_guru', $request->kode_guru)
            ->update($dataUpdate);

        // Sync to users table if exists
        if (Schema::hasTable('users')) {
            try {
                $userData = [
                    'name' => $request->nama_guru,
                    'username' => $request->username,
                    'updated_at' => now(),
                ];
                if (!empty($request->password)) {
                    $userData['password'] = bcrypt($request->password);
                }
                DB::table('users')->where('email', $request->email)->update($userData);
            } catch (\Throwable $e) {}
        }

        if ($update !== false) {
            return Redirect('viewGuru')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewGuru')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

}
