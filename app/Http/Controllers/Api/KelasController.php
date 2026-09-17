<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;


class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::query();
        $query->select('kelas.*','guru.nama_guru', 
        DB::raw('COUNT(siswa.kode_siswa) as totalSiswa'), 
        DB::raw('SUM(siswa.jk = "L") as totalL'), 
        DB::raw('SUM(siswa.jk = "P") as totalP'));
        $query->where('kelas.kode_member', $request->kode_member);
        $query->leftJoin('siswa', 'kelas.kode_kelas', '=', 'siswa.kode_kelas');
        $query->join('guru', 'kelas.kode_guru', '=', 'guru.kode_guru');
        if ($request->has('nama_kelas')) {
            $query->where('nama_kelas', 'like', '%' . $request->nama_kelas . '%');
        }
        $query->orderBy('kelas.kode_kelas','ASC');
        $query->groupBy('kelas.kode_kelas','kelas.nama_kelas','jurusan','kelas.kode_guru','kelas.kode_member','guru.nama_guru');
        $kelas = $query->get();

        return response()->json(['data' => $kelas], 200);
    }
    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        return response()->json(['data' => $kelas], 200);
    }
}