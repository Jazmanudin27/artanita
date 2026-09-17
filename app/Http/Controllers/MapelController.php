<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $mapel = DB::table('mapel')
        ->orderBy('mapel.nama_mapel', 'ASC')
        ->get();
        return view('mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $simpan = DB::table('mapel')
            ->insert([
                'nama_mapel' => $request->nama_mapel,
                'kode_member' => Auth::user()->kode_member,
            ]);
        if ($simpan) {
            return Redirect('viewMapel')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewMapel')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function delete(Request $request)
    {
        $hapus = DB::table('mapel')->where('kode_mapel', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewMapel')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewMapel')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $mapel = DB::table('mapel')->where('mapel.kode_mapel', $id)->first();
        return view('mapel.edit', compact('mapel'));
    }

    public function show(Request $request)
    {
        $nama_mapel = $request->nama_mapel;

        $mapel = DB::table('mapel')
        ->when($nama_mapel, function ($query) use ($nama_mapel) {
            return $query->where('mapel.nama_mapel', 'LIKE', '%' . $nama_mapel . '%');
        })
        ->orderBy('mapel.nama_mapel')
        ->get();
        return view('mapel.show', compact('mapel'));
    }

    public function update(Request $request)
    {
        $update = DB::table('mapel')
            ->where('kode_mapel', $request->kode_mapel)
            ->update([
                'nama_mapel' => $request->nama_mapel,
            ]);
        if ($update) {
            return Redirect('viewMapel')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewMapel')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

}
