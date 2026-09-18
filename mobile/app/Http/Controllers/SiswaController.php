<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $siswa = DB::table('siswa')
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $simpan = DB::table('siswa')
            ->insert([
                'nama_siswa' => $request->nama_siswa,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'agama' => $request->agama,
                'email' => $request->email,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'jk' => $request->jk,
                'status' => "Aktif",
                'kode_member' => Auth::user()->kode_member,
            ]);
        if ($simpan) {
            return Redirect('viewSiswa')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewSiswa')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function delete(Request $request)
    {
        $hapus = DB::table('siswa')->where('kode_siswa', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewSiswa')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewSiswa')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $siswa = DB::table('siswa')->where('siswa.kode_siswa', $id)->first();
        return view('siswa.edit', compact('siswa'));
    }

    public function show(Request $request)
    {

        $kode_kelas = $request->kode_kelas;
        $jk = $request->jk;
        $status = $request->status;
        $nama_siswa = $request->nama_siswa;

        if (Auth::guard('kelas')->check()) {
            $kode_kelas = Auth::guard('kelas')->user()->kode_kelas;
        }

        $siswa = DB::table('siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('siswa.kode_kelas', $kode_kelas);
        })
        ->when($status, function ($query) use ($status) {
            return $query->where('siswa.status', $status);
        })
        ->when($jk, function ($query) use ($jk) {
            return $query->where('siswa.jk', $jk);
        })
        ->when($nama_siswa, function ($query) use ($nama_siswa) {
            return $query->where('siswa.nama_siswa', 'LIKE', '%' . $nama_siswa . '%');
        })
        ->orderBy('siswa.nama_siswa')
        ->get();
        return view('siswa.show', compact('siswa'));
    }

    public function update(Request $request)
    {
        $update = DB::table('siswa')
            ->where('kode_siswa', $request->kode_siswa)
            ->update([
                'nama_siswa' => $request->nama_siswa,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'agama' => $request->agama,
                'email' => $request->email,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'jk' => $request->jk,
                'status' => $request->status,
            ]);
        if ($update) {
            return Redirect('viewSiswa')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewSiswa')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

}
