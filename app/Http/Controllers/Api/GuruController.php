<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;


class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();
        if ($request->has('nama_guru')) {
            $query->where('nama_guru', 'like', '%' . $request->nama_guru . '%');
        }
        if ($request->has('kode_guru')) {
            $query->where('kode_guru', $request->kode_guru);
        }
        $query->where('kode_member', $request->kode_member);
        $guru = $query->get();

        return response()->json(['data' => $guru], 200);
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        $presensi = DB::table('presensi')->where('kode_guru', $guru->kode_guru)
            ->whereDate('tanggal', now()->toDateString())
            ->get();
        $histori = DB::table('presensi')
        ->selectRaw('presensi.tanggal,presensi.id,presensi.kode_guru,presensi.jam_in,presensi.jam_out,presensi.foto_in,presensi.foto_out,guru.nama_guru,guru.jk')
        ->join('guru', 'guru.kode_guru', '=', 'presensi.kode_guru')
        ->where('guru.kode_guru', $guru->kode_guru)
        ->orderBy('presensi.tanggal','DESC')
        ->take(7)
        ->get();
        return response()->json(['data' => $guru, 'presensi' => $presensi, 'histori' => $histori], 200);
    }

}
