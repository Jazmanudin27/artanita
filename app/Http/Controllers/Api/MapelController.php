<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $query = Mapel::query();
        $query->where('mapel.kode_member', $request->kode_member);
        if ($request->has('nama_mapel')) {
            $query->where('nama_mapel', 'like', '%' . $request->nama_mapel . '%');
        }
        $mapel = $query->get();

        return response()->json(['data' => $mapel], 200);
    }
    public function mapelGuru(Request $request)
    {
        $query = DB::table('mapel_guru')
            ->select('mapel_guru.kode_guru_mapel','mapel.kode_mapel','guru.nama_guru', 'mapel.nama_mapel')
            ->join('guru', 'mapel_guru.kode_guru', '=', 'guru.kode_guru')
            ->join('mapel', 'mapel_guru.kode_mapel', '=', 'mapel.kode_mapel')
            ->where('mapel_guru.kode_guru', $request->kode_guru)
            ->where('mapel_guru.kode_member', $request->kode_member);
    
        $mapel = $query->get();
    
        return response()->json(['data' => $mapel], 200);
    }

    public function show($id)
    {
        $mapel = Mapel::findOrFail($id);
        return response()->json(['data' => $mapel], 200);
    }
}