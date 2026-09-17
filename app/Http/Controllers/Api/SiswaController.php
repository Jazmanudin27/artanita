<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{

    public function index(Request $request)
    {
        $query = Siswa::query();
        
        $query->join('kelas', 'siswa.kode_kelas', 'kelas.kode_kelas');
        if ($request->has('nama_siswa')) {
            $query->where('nama_siswa', 'like', '%' . $request->nama_siswa . '%');
        }
        if ($request->has('jk')) {
            $query->where('siswa.jk', $request->jk);
        }
        if ($request->has('kode_siswa')) {
            $query->where('kode_siswa', $request->kode_siswa);
        }
        $query->where('siswa.kode_member', $request->kode_member);
        $query->where('siswa.status', 'Aktif');
        $query->orderBy('nama_siswa', 'ASC');
        $siswa = $query->get();

        return response()->json(['data' => $siswa], 200);
    }

       

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            // Tambahkan validasi sesuai kebutuhan
        ]);

        $siswa = Siswa::create($validatedData);
        return response()->json(['message' => 'Siswa created', 'data' => $siswa], 201);
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json(['data' => $siswa], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            // Tambahkan validasi sesuai kebutuhan
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($validatedData);
        return response()->json(['message' => 'Siswa updated', 'data' => $siswa], 200);
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return response()->json(['message' => 'Siswa deleted'], 200);
    }
}