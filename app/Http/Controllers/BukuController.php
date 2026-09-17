<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = DB::table('buku')
        ->orderBy('buku.judul', 'ASC')
        ->get();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $simpan = DB::table('buku')
            ->insert([
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'jumlah_stok' => $request->jumlah_stok,
                'kode_member' => Auth::guard('user')->user()->kode_member,
            ]);
        if ($simpan) {
            return Redirect('viewBuku')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewBuku')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function delete(Request $request)
    {
        $hapus = DB::table('buku')->where('kode_buku', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewBuku')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewBuku')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $buku = DB::table('buku')->where('buku.kode_buku', $id)->first();
        return view('buku.edit', compact('buku'));
    }

    public function show(Request $request)
    {
        $judul = $request->judul;
        $pengarang = $request->pengarang;
        $penerbit = $request->penerbit;

        $buku = DB::table('buku')
        ->when($judul, function ($query) use ($judul) {
            return $query->where('buku.judul', 'LIKE', '%' . $judul . '%');
        })
        ->when($pengarang, function ($query) use ($pengarang) {
            return $query->where('buku.pengarang', 'LIKE', '%' . $pengarang . '%');
        })
        ->when($penerbit, function ($query) use ($penerbit) {
            return $query->where('buku.penerbit', 'LIKE', '%' . $penerbit . '%');
        })
        ->orderBy('buku.judul')
        ->get();
        return view('buku.show', compact('buku'));
    }

    public function update(Request $request)
    {
        $update = DB::table('buku')
            ->where('kode_buku', $request->kode_buku)
            ->update([
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'jumlah_stok' => $request->jumlah_stok,
            ]);
        if ($update) {
            return Redirect('viewBuku')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewBuku')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }
}
