<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;


class AbsensiController extends Controller
{

    public function countAbsensiSiswa(Request $request)
    {
        $id         = $request->id;
        $bulan      = Date('m');
        $tahun      = Date('Y');

        $sakit = DB::table('absensi_siswa')
            ->where('kode_siswa', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'S')
            ->count();

        $izin = DB::table('absensi_siswa')
            ->where('kode_siswa', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'I')
            ->count();

        $alfa = DB::table('absensi_siswa')
            ->where('kode_siswa', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'A')
            ->count();

        return response()->json([
            'sakit' => $sakit,
            'izin' => $izin,
            'alfa' => $alfa,
        ], 200);
    }

    public function rekapAbsensiSiswa(Request $request)
    {
        $siswaData = DB::table('siswa')
        ->leftJoin(DB::raw("(SELECT 
                absensi_siswa.kode_siswa,
                COUNT(CASE WHEN absensi_siswa.status IN ('I', 'S', 'A') THEN absensi_siswa.status ELSE NULL END) AS total_absensi,
                COUNT(CASE WHEN absensi_siswa.status = 'I' THEN absensi_siswa.status ELSE NULL END) AS total_izin,
                COUNT(CASE WHEN absensi_siswa.status = 'S' THEN absensi_siswa.status ELSE NULL END) AS total_sakit,
                COUNT(CASE WHEN absensi_siswa.status = 'A' THEN absensi_siswa.status ELSE NULL END) AS total_alfa
            FROM absensi_siswa
            WHERE absensi_siswa.kode_kelas = '$request->kode_kelas'
            GROUP BY absensi_siswa.kode_siswa
        ) abs"), function ($join) {
            $join->on('abs.kode_siswa', '=', 'siswa.kode_siswa');
        })
        ->join('kelas', 'kelas.kode_kelas', '=', 'siswa.kode_kelas')
        ->where('siswa.kode_kelas', '=', $request->kode_kelas)
        ->where('siswa.kode_member', '=', $request->kode_member)
        ->select(
            'siswa.nama_siswa',
            'siswa.kode_siswa',
            'siswa.kode_kelas',
            'siswa.jk',
            'siswa.nisn',
            'kelas.jurusan',
            'kelas.nama_kelas',
            'abs.total_absensi',
            'abs.total_izin',
            'abs.total_sakit',
            'abs.total_alfa'
        )
        ->orderBy('nama_siswa','ASC')
        ->get();

        return response()->json(['data' => $siswaData], 200);
    }

    public function getAbsensiSiswa(Request $request)
    {
        $siswa = DB::table("siswa")
        ->selectRaw('kelas.nama_kelas,kelas.jurusan,siswa.kode_siswa,siswa.kode_kelas,siswa.nama_siswa,siswa.jk,siswa.nisn,absnsiswa.id,absnsiswa.status,absnsiswa.tanggal')
        ->join('kelas', 'kelas.kode_kelas', '=', 'siswa.kode_kelas')
        ->leftJoin(DB::raw("(SELECT id,absensi_siswa.tanggal,absensi_siswa.status,absensi_siswa.kode_siswa FROM absensi_siswa 
            WHERE absensi_siswa.tanggal = '$request->tanggal' 
            GROUP BY id,absensi_siswa.tanggal,absensi_siswa.status,absensi_siswa.kode_siswa) absnsiswa"), function ($join) {
                $join->on('absnsiswa.kode_siswa', '=', 'siswa.kode_siswa');
            })
        ->where('siswa.kode_kelas', $request->kode_kelas)
        ->get();
        return response()->json(['data' => $siswa], 200);
    }
    public function storeAbsensiSiswa(Request $request)
    {
        $id = $request->id;
        $kodeKelas = $request->kode_kelas;
        $tanggal = $request->tanggal;
        $kodeSiswa = $request->kode_siswa;
        $status = $request->status;

        try {
            DB::beginTransaction();
                $update = DB::table('absensi_siswa')
                ->where('tanggal', $tanggal)
                ->where('kode_siswa', $kodeSiswa)
                ->where('kode_kelas', $kodeKelas)
                ->update([
                    'tanggal' => $tanggal,
                    'kode_siswa' => $kodeSiswa,
                    'kode_kelas' => $kodeKelas,
                    'status' => $status,
                ]);
                if (!$update) {
                     $simpan = DB::table('absensi_siswa')->insert([
                        'tanggal' => $tanggal,
                        'kode_kelas' => $kodeKelas,
                        'kode_siswa' => $kodeSiswa,
                        'status' => $status,
                    ]);
                    if (!$simpan) {
                        DB::rollBack();
                        return response()->json(['message' => 'Data Gagal Disimpan'], 500);
                    }
                }
            DB::commit();
            return response()->json(['message' => 'Data Berhasil Disimpan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function getAbsensiMapel(Request $request)
    {
        $siswa = DB::table("siswa")
        ->selectRaw('kelas.nama_kelas,kelas.jurusan,siswa.kode_siswa,siswa.kode_kelas,siswa.nama_siswa,siswa.jk,siswa.nisn,absnsiswa.id,absnsiswa.status,absnsiswa.tanggal')
        ->join('kelas', 'kelas.kode_kelas', '=', 'siswa.kode_kelas')
        ->leftJoin(DB::raw("(SELECT id,absensi_mapel.tanggal,absensi_mapel.status,absensi_mapel.kode_siswa,absensi_mapel.kode_mapel,mapel.nama_mapel 
        FROM absensi_mapel 
        INNER JOIN mapel ON mapel.kode_mapel = absensi_mapel.kode_mapel    
        WHERE absensi_mapel.tanggal = '$request->tanggal' AND absensi_mapel.kode_mapel = '$request->kode_mapel'  AND absensi_mapel.kode_guru = '$request->kode_guru' 
            GROUP BY id,absensi_mapel.tanggal,absensi_mapel.status,absensi_mapel.kode_siswa,absensi_mapel.kode_mapel,mapel.nama_mapel ) absnsiswa"), function ($join) {
                $join->on('absnsiswa.kode_siswa', '=', 'siswa.kode_siswa');
            })
        ->where('siswa.kode_kelas', $request->kode_kelas)
        ->get();
        return response()->json(['data' => $siswa], 200);
    }
    public function storeAbsensiMapel(Request $request)
    {
        $id = $request->id;
        $kodeKelas = $request->kode_kelas;
        $tanggal = $request->tanggal;
        $kodeMapel = $request->kode_mapel;
        $kodeGuru = $request->kode_guru;
        $kodeSiswa = $request->kode_siswa;
        $status = $request->status;

        try {
            DB::beginTransaction();
            $update = DB::table('absensi_mapel')
            ->where('tanggal', $tanggal)
            ->where('kode_siswa', $kodeSiswa)
            ->where('kode_mapel', $kodeMapel)
            ->where('kode_guru', $kodeGuru)
            ->where('kode_kelas', $kodeKelas)
            ->update([
                'tanggal' => $tanggal,
                'kode_siswa' => $kodeSiswa,
                'kode_guru' => $kodeGuru,
                'kode_mapel' => $kodeMapel,
                'kode_kelas' => $kodeKelas,
                'status' => $status,
            ]);
            if (!$update) {
                     $simpan = DB::table('absensi_mapel')->insert([
                    'tanggal' => $tanggal,
                    'kode_kelas' => $kodeKelas,
                    'kode_siswa' => $kodeSiswa,
                    'kode_guru' => $kodeGuru,
                    'kode_mapel' => $kodeMapel,
                    'status' => $status,
                ]);
                if (!$simpan) {
                    DB::rollBack();
                    return response()->json(['message' => 'Data Gagal Disimpan'], 500);
                }
            }
            DB::commit();
            return response()->json(['message' => 'Data Berhasil Disimpan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

}