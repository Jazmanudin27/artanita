<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $kelas = DB::table('kelas')
        ->where('kode_member', Auth::user()->kode_memeber)
        ->orderBy('kelas.nama_kelas', 'ASC')
        ->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $data = [
            'nama_kelas' => $request->nama_kelas,
            'jurusan' => $request->jurusan,
            'kode_guru' => $request->kode_guru,
            'kode_member' => Auth::user()->kode_member,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : null,
        ];

        $simpan = DB::table('kelas')->insert($data);
        if ($simpan) {
            return Redirect('viewKelas')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewKelas')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function delete(Request $request)
    {
        $hapus = DB::table('kelas')->where('kode_kelas', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewKelas')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewKelas')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $kelas = DB::table('kelas')->where('kelas.kode_kelas', $id)->first();
        return view('kelas.edit', compact('kelas'));
    }

    public function show(Request $request)
    {
        $nama_kelas = $request->nama_kelas;

        $kelas = DB::table('kelas')
        ->leftJoin('guru','kelas.kode_guru','guru.kode_guru')
        ->select('kelas.*', 'guru.nama_guru')
        ->when($nama_kelas, function ($query) use ($nama_kelas) {
            return $query->where('kelas.nama_kelas', 'LIKE', '%' . $nama_kelas . '%');
        })
        ->orderBy('kelas.nama_kelas')
        ->get();
        return view('kelas.show', compact('kelas'));
    }

    public function update(Request $request)
    {
        $data = [
            'nama_kelas' => $request->nama_kelas,
            'jurusan' => $request->jurusan,
            'kode_guru' => $request->kode_guru,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $update = DB::table('kelas')
            ->where('kode_kelas', $request->kode_kelas)
            ->update($data);
        if ($update) {
            return Redirect('viewKelas')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewKelas')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

}
