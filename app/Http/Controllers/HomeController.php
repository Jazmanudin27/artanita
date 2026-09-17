<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('siswa')->check()) {
            return view('home.dashboardSiswa');
        } else if (Auth::guard('guru')->check()) {
            return view('home.dashboardGuru');
        } else if (Auth::guard('web')->check()) {
            return view('home.dashboardAdmin');
        }  else {
            return view('auth.login');
        }
    }
    public function loadAbsensiSiswaPerKelas(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kelas = DB::table('kelas')
        ->where('kode_member',Auth::guard('web')->user()->kode_member)
        ->orderBy('kelas.nama_kelas', 'ASC')
        ->get();
        return view('home.loadAbsensiSiswaPerKelas', compact('kelas','bulan','tahun'));
    }
    public function loadAbsensiSiswaPerSiswa(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kode_kelas = $request->kode_kelas;

        $siswa = DB::table('siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->where('siswa.kode_kelas',$kode_kelas)
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('home.loadAbsensiSiswaPerSiswa', compact('siswa','bulan','tahun'));
    }
    public function loadTeguran(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kode_kelas = $request->kode_kelas;

        $teguran = DB::table('surat_teguran')
        ->join('siswa','surat_teguran.kode_siswa','siswa.kode_siswa')
        ->join('kelas','surat_teguran.kode_kelas','kelas.kode_kelas')
        ->whereRaw("MONTH(surat_teguran.tanggal) = '$bulan'")
        ->whereRaw("YEAR(surat_teguran.tanggal) = '$tahun'")
        ->where('siswa.kode_kelas',$kode_kelas)
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('home.loadTeguran', compact('teguran','bulan','tahun'));
    }
    public function loadAbsensiMapel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kode_mapel = $request->kode_mapel;
        $kode_kelas = $request->kode_kelas;

        $siswa = DB::table('siswa')
        ->where('kode_kelas',$kode_kelas)
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('home.loadAbsensiMapel', compact('siswa','bulan','tahun','kode_kelas','kode_mapel'));
    }

    public function loadJadwal(Request $request)
    {
        $kode_member    = Auth::user()->kode_member;
        $hari           = $request->hari;

        $member = DB::table('member')
        ->where('member.kode_member',$kode_member)
        ->first();

        $jamKe = DB::table('jadwal_jam')
        ->selectRaw("kode_jam,jam_ke,jam")
        ->get();

        $kelas = DB::table('kelas')
            ->orderBy('nama_kelas','ASC')
            ->where('kode_member', $kode_member)
            ->get();

        $jmlKelas = DB::table('kelas')
            ->orderBy('nama_kelas','ASC')
            ->where('kode_member', $kode_member)
            ->count();

        $guru = DB::table('guru')
            ->where('kode_member', $kode_member)
            ->orderBy('nama_guru','ASC')
            ->get();

        return view('home.loadJadwal', compact('member','kelas','jmlKelas','guru','jamKe','hari'));
    }

}
