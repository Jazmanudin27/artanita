<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{

    public function getJadwalPelajaran(Request $request)
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
        return response()->json(['data' => $jadwal], 200);
    }
}