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
            return view('home.siswa');
        } else if (Auth::guard('guru')->check()) {
            return view('home.guru');
        } else if (Auth::guard('kelas')->check()) {
            return view('home.admin');
        } else if (Auth::guard('web')->check() || Auth::check()) {
            return view('home.admin');
        } else {
            return view('auth.login');
        }
    }

    public function viewJadwal()
    {
        return view('jadwal.viewJadwal');
    }
    public function showJadwal(Request $request)
    {
        $jadwal = DB::table('jadwal_jam')
        ->leftJoin(DB::raw("(SELECT jadwal.kode_jam, hari, nama_guru, nama_mapel
            FROM jadwal
            INNER JOIN mapel_guru ON mapel_guru.kode_guru_mapel = jadwal.kode_guru_mapel
            INNER JOIN guru ON guru.kode_guru = mapel_guru.kode_guru
            INNER JOIN mapel ON mapel.kode_mapel = mapel_guru.kode_mapel
            WHERE hari = '$request->hari' AND kode_kelas = '$request->kode_kelas'
            GROUP BY jadwal.kode_jam, hari, nama_guru, nama_mapel) as jdwl"), function ($join) {
                $join->on('jdwl.kode_jam', '=', 'jadwal_jam.kode_jam');
            })
        ->orderBy('jadwal_jam.kode_jam', 'ASC')
        ->select('jadwal_jam.jam', 'jdwl.hari', 'jdwl.nama_guru', 'jdwl.nama_mapel')
        ->get();
        return view('jadwal.showJadwal',compact('jadwal'));
    }

}
