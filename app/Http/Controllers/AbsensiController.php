<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function viewAbsensiSiswa(Request $request)
    {
        return view('absensi.viewAbsensiSiswa');
    }

    public function createAbsensiSiswa()
    {
        return view('absensi.createAbsensiSiswa');
    }

    public function storeAbsensiSiswa(Request $request)
    {
        $simpan = DB::table('absensi_siswa')
            ->insert([
                'tanggal' => $request->tanggal,
                'kode_kelas' => $request->kode_kelas,
                'kode_siswa' => $request->kode_siswa,
                'status' => $request->status,
                'kode_member' => Auth::user()->kode_member,
            ]);
        if ($simpan) {
            return Redirect('viewAbsensiSiswa')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewAbsensiSiswa')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function deleteAbsensiSiswa(Request $request)
    {
        $hapus = DB::table('absensi_siswa')->where('id', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewAbsensiSiswa')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewAbsensiSiswa')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function editAbsensiSiswa($id)
    {
        $absensi = DB::table('absensi_siswa')->where('absensi_siswa.id', $id)->first();
        return view('absensi.editAbsensiSiswa', compact('absensi'));
    }

    public function showAbsensiSiswa(Request $request)
    {
        $tanggal = $request->tanggal;
        $kode_kelas = $request->kode_kelas;
        $nama_siswa = $request->nama_siswa;

        $absensi_siswa = DB::table('absensi_siswa')
        ->select('absensi_siswa.id','nisn','nis','nama_siswa','jk','absensi_siswa.status','absensi_siswa.tanggal','nama_kelas','jurusan')
        ->join('siswa','siswa.kode_siswa','absensi_siswa.kode_siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->when($tanggal, function ($query) use ($tanggal) {
            return $query->where('absensi_siswa.tanggal', $tanggal);
        })
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('absensi_siswa.kode_kelas', $kode_kelas);
        })
        ->when($nama_siswa, function ($query) use ($nama_siswa) {
            return $query->where('absensi_siswa.nama_siswa', 'LIKE', '%' . $nama_siswa . '%');
        })
        ->orderBy('siswa.nama_siswa','ASC')
        ->get();
        return view('absensi.showAbsensiSiswa', compact('absensi_siswa'));
    }

    public function updateAbsensiSiswa(Request $request)
    {
        $update = DB::table('absensi_siswa')
            ->where('id', $request->id)
            ->update([
                'tanggal' => $request->tanggal,
                'kode_siswa' => $request->kode_siswa,
                'status' => $request->status,
            ]);
        if ($update) {
            return Redirect('viewAbsensiSiswa')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewAbsensiSiswa')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }
}
