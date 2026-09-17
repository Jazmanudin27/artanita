<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $soal = DB::table('soal')
        ->orderBy('soal.pertanyaan', 'ASC')
        ->get();
        return view('soal.index', compact('soal'));
    }

    public function isiSoal()
    {
        $soal = DB::table('soal')->where('soal.kategori', request()->segment(2))->get();
        $kategori = DB::table('soal')->select('kategori')->groupBy('kategori')->get();
        return view('soal.isiSoal',compact('soal','kategori'));
    }

    public function create()
    {
        return view('soal.create');
    }

    public function store(Request $request)
    {
        $simpan = DB::table('soal')
            ->insert([
                'pertanyaan' => $request->pertanyaan,
                'kategori' => $request->kategori,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'jawaban_benar' => $request->jawaban_benar,
            ]);
        if ($simpan) {
            return Redirect('viewSoal')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewSoal')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function updateJawaban(Request $request)
    {
        $cekSoal = DB::table('jawaban')
        ->where('id_soal',$request->id_soal)
        ->where('nama_lengkap',$request->nama_lengkap)
        ->where('pendidikan',$request->pendidikan)
        ->where('jurusan',$request->jurusan)
        ->where('no_hp',$request->no_hp)
        ->count();

        if($cekSoal > 0){
            DB::table('jawaban')
            ->where('id_soal',$request->id_soal)
            ->where('nama_lengkap',$request->nama_lengkap)
            ->where('pendidikan',$request->pendidikan)
            ->where('jurusan',$request->jurusan)
            ->where('no_hp',$request->no_hp)
            ->update([
                'jawaban' => $request->jawaban,
            ]);
        }else{
            DB::table('jawaban')
            ->insert([
                'id_soal' => $request->id_soal,
                'jawaban' => $request->jawaban,
                'nama_lengkap' => $request->nama_lengkap,
                'pendidikan' => $request->pendidikan,
                'jurusan' => $request->jurusan,
                'no_hp' => $request->no_hp,
            ]);
        }
    }



    public function delete(Request $request)
    {
        $hapus = DB::table('soal')->where('id_soal', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewSoal')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewSoal')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $soal = DB::table('soal')->where('soal.id_soal', $id)->first();
        return view('soal.edit', compact('soal'));
    }

    public function show(Request $request)
    {
        $kategori = $request->kategori;

        $soal = DB::table('soal')
        ->when($kategori, function ($query) use ($kategori) {
            return $query->where('soal.kategori', 'LIKE', '%' . $kategori . '%');
        })
        ->orderBy('soal.id_soal','ASC')
        ->get();
        return view('soal.show', compact('soal'));
    }

    public function update(Request $request)
    {
        $update = DB::table('soal')
            ->where('id_soal', $request->id_soal)
            ->update([
                'kategori' => $request->kategori,
                'pertanyaan' => $request->pertanyaan,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'jawaban_benar' => $request->jawaban_benar,
            ]);
        if ($update) {
            return Redirect('viewSoal')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewSoal')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

}
