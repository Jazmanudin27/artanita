<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{

    public function getPresensi(Request $request)
    {
        $guru = DB::table('presensi')
        ->selectRaw('presensi.tanggal,presensi.id,presensi.kode_guru,presensi.jam_in,presensi.jam_out,presensi.foto_in,presensi.foto_out,guru.nama_guru,guru.jk')
        ->join('guru', 'guru.kode_guru', '=', 'presensi.kode_guru')
        ->where('guru.kode_guru', $request->kode_guru)
        ->whereMonth('presensi.tanggal', $request->bulan)
        ->whereYear('presensi.tanggal', $request->tahun)
        ->orderBy('presensi.tanggal','DESC')
        ->get();
        return response()->json(['data' => $guru], 200);
    }
    public function countAbsensi(Request $request)
    {
        $id         = $request->id;
        $bulan      = Date('m');
        $tahun      = Date('Y');

        $hadir = DB::table('presensi')
            ->where('kode_guru', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereNotNull('jam_out')
            ->count();

        $sakit = DB::table('surat_absen')
            ->where('kode_guru', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('jenis_absen', 'Sakit')
            ->count();

        $izin = DB::table('surat_absen')
            ->where('kode_guru', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('jenis_absen', 'Izin')
            ->count();

        $cuti = DB::table('surat_absen')
            ->where('kode_guru', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('jenis_absen', 'Cuti')
            ->count();

        return response()->json([
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'cuti' => $cuti,
        ], 200);
    }

    public function checkin(Request $request)
    {
        $kodeGuru = $request->kode_guru;
        $tanggal = date('Y-m-d');
        $jamSekarang = date('H:i:s');
        $fotoIn = null;
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $namaFileBaru = "Checkin-$tanggal-$kodeGuru." . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('upload/presensi', $namaFileBaru, 'public');
            $fotoIn = $filePath;
        }
    
        $presensi = DB::table('presensi')->insert([
            'kode_guru' => $kodeGuru,
            'tanggal' => $tanggal,
            'jam_in' => $jamSekarang,
            'jam_out' => null,
            'foto_in' => $fotoIn,
            'foto_out' => null,
            'lokasi_in' => $request->lokasi_in,
            'lokasi_out' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        if ($presensi) {
            return response()->json(['message' => 'Presensi berhasil ditambahkan'], 201);
        } else {
            return response()->json(['message' => 'Gagal menambahkan presensi'], 500);
        }
    }

    public function checkout(Request $request)
    {
        $kodeGuru = $request->kode_guru;
        $tanggal = date('Y-m-d');
        $jamSekarang = date('H:i:s');
        $fotoOut = null;
    
        $existingPresensi = DB::table('presensi')
            ->where('kode_guru', $kodeGuru)
            ->where('tanggal', $tanggal)
            ->first();
    
        if ($existingPresensi) {
            $updateData = [
                'jam_out' => $jamSekarang,
                'lokasi_out' => $request->lokasi_out,
                'updated_at' => now(),
            ];
    
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $namaFileBaru = "Checkout-$tanggal-$kodeGuru." . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('upload/presensi', $namaFileBaru, 'public');
                $fotoOut = $filePath;
                $updateData['foto_out'] = $fotoOut;
            } else {
                $updateData['foto_out'] = null;
            }
    
            $update = DB::table('presensi')
                ->where('kode_guru', $kodeGuru)
                ->where('tanggal', $tanggal)
                ->update($updateData);
    
            if ($update) {
                return response()->json(['message' => 'Presensi berhasil diperbarui'], 200);
            } else {
                return response()->json(['message' => 'Gagal memperbarui presensi'], 500);
            }
        } else {
            return response()->json(['message' => 'Data presensi tidak ditemukan'], 404);
        }
    }

}