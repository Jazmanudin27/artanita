<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JadwalController extends Controller
{
    public function viewJadwal(Request $request)
    {

        $member = DB::table('member')
        ->where('member.kode_member',Auth::user()->kode_member)
        ->first();
        return view('jadwal.viewJadwal', compact('member'));
    }
    public function showJadwal(Request $request)
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
            ->where('nama_kelas','!=', 'ALUMNI')
            ->get();

        $jmlKelas = DB::table('kelas')
            ->orderBy('nama_kelas','ASC')
            ->where('kode_member', $kode_member)
            ->where('nama_kelas','!=', 'ALUMNI')
            ->count();

        $guru = DB::table('mapel_guru')
            ->join('guru','guru.kode_guru','mapel_guru.kode_guru')
            ->join('mapel','mapel.kode_mapel','mapel_guru.kode_mapel')
            ->where('mapel_guru.kode_member', $kode_member)
            ->orderByRaw('CAST(no_urut AS UNSIGNED) ASC')
            ->get();

        return view('jadwal.showJadwal', compact('member','kelas','jmlKelas','guru','jamKe','hari'));
    }

    public function simpanJadwal(Request $request)
    {

        $kode_member    = Auth::user()->kode_member;
        DB::table('jadwal')
        ->insert([
            'hari' => $request->hari,
            'kode_jam' => $request->kode_jam,
            'kode_kelas' => $request->kode_kelas,
            'kode_guru_mapel' => $request->kode_guru_mapel,
            'kode_member' => $kode_member,
        ]);

    }

    public function cekData(Request $request)
    {
        return DB::table('jadwal')
            ->where('kode_guru_mapel', $request->kode_guru_mapel)
            ->where('kode_jam', $request->kode_jam)
            ->where('hari', $request->hari)
            ->count();
    }

    public function updateJadwal(Request $request)
    {
        DB::table('jadwal')
        ->where('kode_jadwal',$request->kode_jadwal)
        ->update([
            'kode_guru_mapel' => $request->kode_guru_mapel,
        ]);
    }

    public function updateJam(Request $request)
    {
        DB::table('jadwal_jam')
        ->where('kode_jam',$request->kode_jam)
        ->update([
            'jam' => $request->jam,
        ]);
    }

}
