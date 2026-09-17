<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi.scan');
    }

    public function scanMasuk(Request $request)
    {
        DB::table('presensi')->insert([
            'kode_guru' => Auth::guard('guru')->user()->kode_guru,
            'tanggal' => date('Y-m-d'),
            'jam_in' => date('H:i:s'),
            'lokasi_in' => $request->latitude . ', ' . $request->longitude,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function scanPulang(Request $request)
    {
        DB::table('presensi')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->where('tanggal', date('Y-m-d'))
            ->update([
                'jam_out' => date('H:i:s'),
                'lokasi_out' => $request->latitude . ', ' . $request->longitude,
                'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function viewPresensi()
    {
        return view('absensi.viewPresensi');
    }

    public function showPresensi(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        if (Auth::guard('guru')->check()) {
            $kode = Auth::guard('guru')->user()->kode_guru;
        } else {
            $kode = Auth::user()->id;
        }

        $absensi = DB::table('presensi')
        ->join('guru','guru.kode_guru','presensi.kode_guru')
        ->whereMonth('presensi.tanggal', $bulan)
        ->whereYear('presensi.tanggal', $tahun)
        ->when($kode, function ($query) use ($kode) {
            return $query->where('presensi.kode_guru', $kode);
        })
        ->orderBy('guru.nama_guru')
        ->get();
        return view('absensi.showPresensi', compact('absensi'));
    }
    public function viewAbsensiSiswa()
    {
        return view('absensi.viewAbsensiSiswa');
    }

    public function showAbsensiSiswa(Request $request)
    {

        $tanggal = $request->tanggal;
        $kode_kelas = $request->kode_kelas;

        $siswa = DB::table('siswa')
        ->select('siswa.kode_siswa','siswa.kode_kelas', 'siswa.nama_siswa','kelas.nama_kelas', 'abs.tanggal', 'abs.status')
        ->leftJoin(DB::raw("(SELECT kode_siswa, status, tanggal FROM absensi_siswa WHERE tanggal = '$tanggal') as abs"), function ($join) {
            $join->on('siswa.kode_siswa', '=', 'abs.kode_siswa');
        })
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->where('siswa.kode_kelas',$kode_kelas)
        ->where('siswa.status', '=', 'Aktif')
        ->groupBy('siswa.kode_siswa','siswa.kode_kelas', 'siswa.nama_siswa','kelas.nama_kelas', 'abs.tanggal', 'abs.status')
        ->orderBy('siswa.nama_siswa')
        ->get();
        return view('absensi.showAbsensiSiswa', compact('siswa'));
    }

    public function createAbsensiSiswa(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $kodeSiswa = $request->input('kode_siswa');
        $kodeKelas = $request->input('kode_kelas');
        $status = $request->input('status');

        DB::transaction(function () use ($kodeSiswa, $kodeKelas, $status, $tanggal) {
            DB::table('absensi_siswa')
                ->where('kode_siswa', $kodeSiswa)
                ->where('kode_kelas', $kodeKelas)
                ->where('tanggal', $tanggal)
                ->delete();

            DB::table('absensi_siswa')->insert([
                'tanggal' => $tanggal,
                'kode_kelas' => $kodeKelas,
                'kode_siswa' => $kodeSiswa,
                'status' => $status,
            ]);
        });
    }
    public function viewAbsensiMapel()
    {
        return view('absensi.viewAbsensiMapel');
    }

    public function showAbsensiMapel(Request $request)
    {

        $tanggal = $request->tanggal;
        $kode_kelas = $request->kode_kelas;
        $kode_mapel = $request->kode_mapel;

        $siswa = DB::table('siswa')
        ->select('siswa.kode_siswa','siswa.kode_kelas', 'siswa.nama_siswa','kelas.nama_kelas', 'abs.tanggal', 'abs.status')
        ->leftJoin(DB::raw("(SELECT kode_siswa, status, tanggal FROM absensi_mapel WHERE tanggal = '$tanggal' AND kode_mapel = '$kode_mapel') as abs"), function ($join) {
            $join->on('siswa.kode_siswa', '=', 'abs.kode_siswa');
        })
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->where('siswa.kode_kelas', $kode_kelas)
        ->where('siswa.status', '=', 'Aktif')
        ->groupBy('siswa.kode_siswa','siswa.kode_kelas', 'siswa.nama_siswa','kelas.nama_kelas', 'abs.tanggal', 'abs.status')
        ->orderBy('siswa.nama_siswa')
        ->get();
        return view('absensi.showAbsensiMapel', compact('siswa'));
    }

    public function createAbsensiMapel(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $kodeSiswa = $request->input('kode_siswa');
        $kodeKelas = $request->input('kode_kelas');
        $kodeMapel = $request->input('kode_mapel');
        $status = $request->input('status');

        DB::transaction(function () use ($kodeSiswa, $kodeMapel, $kodeKelas, $status, $tanggal) {
            DB::table('absensi_mapel')
                ->where('kode_siswa', $kodeSiswa)
                ->where('kode_mapel', $kodeMapel)
                ->where('kode_kelas', $kodeKelas)
                ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
                ->where('tanggal', $tanggal)
                ->delete();

            DB::table('absensi_mapel')->insert([
                'tanggal' => $tanggal,
                'kode_kelas' => $kodeKelas,
                'kode_siswa' => $kodeSiswa,
                'kode_mapel' => $kodeMapel,
                'kode_guru' => Auth::guard('guru')->user()->kode_guru,
                'status' => $status,
            ]);
        });
    }
}
