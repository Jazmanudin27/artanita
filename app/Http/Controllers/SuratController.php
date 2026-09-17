<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuratController extends Controller
{
    public function indexSuratAbsen(Request $request)
    {
        return view('surat.indexSuratAbsen');
    }

    public function createSuratAbsen()
    {
        return view('surat.createSuratAbsen');
    }

    public function storeSuratAbsen(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $startDate = Carbon::parse($dari);
        $endDate = Carbon::parse($sampai);

        while ($startDate->lte($endDate)) {
            $simpan = DB::table('surat_absen')
            ->insert([
                'kode_guru' => $request->kode_guru,
                'jenis_absen' => $request->jenis_absen,
                'tanggal' => $startDate->toDateString(),
                'deskripsi' => $request->deskripsi,
                'status' => 1,
                'kode_member' => Auth::user()->kode_member,
            ]);
            $startDate->addDay();
        }

        if ($simpan) {
            return Redirect('viewSuratAbsen')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewSuratAbsen')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function deleteSuratAbsen(Request $request)
    {
        $hapus = DB::table('surat_absen')->where('id', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewSuratAbsen')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewSuratAbsen')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function editSuratAbsen($id)
    {
        $surat = DB::table('surat_absen')->where('surat_absen.id', $id)->first();
        return view('surat.editSuratAbsen', compact('surat'));
    }

    public function showSuratAbsen(Request $request)
    {
        $nama_guru = $request->nama_guru;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $surat_absen = DB::table('surat_absen')
        ->selectRaw('surat_absen.id,nama_guru,surat_absen.tanggal,surat_absen.status,surat_absen.jenis_absen,surat_absen.deskripsi')
        ->join('guru','surat_absen.kode_guru','guru.kode_guru')
        ->when($nama_guru, function ($query) use ($nama_guru) {
            return $query->where('guru.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        })
        ->whereRaw("MONTH(surat_absen.tanggal) = '$bulan'")
        ->whereRaw("YEAR(surat_absen.tanggal) = '$tahun'")
        ->orderBy('surat_absen.tanggal', 'DESC')
        ->orderBy('guru.nama_guru', 'ASC')
        ->get();
        return view('surat.showSuratAbsen', compact('surat_absen'));
    }

    public function updateSuratAbsen(Request $request)
    {
        $update = DB::table('surat_absen')
            ->where('id', $request->id)
            ->update([
                'jenis_absen' => $request->jenis_absen,
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
            ]);
        if ($update) {
            return Redirect('viewSuratAbsen')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewSuratAbsen')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function approveSuratAbsen(Request $request)
    {
        DB::table('surat_absen')
        ->where('id', $request->id)
        ->update([
            'status' => $request->status,
        ]);

    }

    public function indexSuratTeguran(Request $request)
    {
        return view('surat.indexSuratTeguran');
    }

    public function createSuratTeguran()
    {
        return view('surat.createSuratTeguran');
    }

    public function storeSuratTeguran(Request $request)
    {
        $dari = $request->tanggal;
        $sampai = $request->tanggal;

        $startDate = Carbon::parse($dari);
        $endDate = Carbon::parse($sampai);

        while ($startDate->lte($endDate)) {
            $siswa = DB::table('siswa')->where('kode_siswa',$request->kode_siswa)->first();
            $simpan = DB::table('surat_teguran')
            ->insert([
                'kode_siswa' => $request->kode_siswa,
                'kode_kelas' => $siswa->kode_kelas,
                'tanggal' => $startDate->toDateString(),
                'deskripsi' => $request->deskripsi,
                'kode_member' => Auth::user()->kode_member,
            ]);
            $startDate->addDay();
        }

        if ($simpan) {
            return Redirect('viewSuratTeguran')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewSuratTeguran')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function deleteSuratTeguran(Request $request)
    {
        $hapus = DB::table('surat_teguran')->where('id', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewSuratTeguran')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewSuratTeguran')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function editSuratTeguran($id)
    {
        $surat_teguran = DB::table('surat_teguran')->where('surat_teguran.id', $id)->first();
        return view('surat.editSuratTeguran', compact('surat_teguran'));
    }

    public function showSuratTeguran(Request $request)
    {
        $nama_siswa = $request->nama_siswa;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $surat_teguran = DB::table('surat_teguran')
        ->join('siswa','surat_teguran.kode_siswa','siswa.kode_siswa')
        ->join('kelas','surat_teguran.kode_kelas','kelas.kode_kelas')
        ->whereRaw("MONTH(surat_teguran.tanggal) = '$bulan'")
        ->whereRaw("YEAR(surat_teguran.tanggal) = '$tahun'")
        ->when($nama_siswa, function ($query) use ($nama_siswa) {
            return $query->where('siswa.nama_siswa', 'LIKE', '%' . $nama_siswa . '%');
        })
        ->orderBy('surat_teguran.tanggal', 'DESC')
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('surat.showSuratTeguran', compact('surat_teguran'));
    }

    public function updateSuratTeguran(Request $request)
    {
        $update = DB::table('surat_teguran')
            ->where('id', $request->id)
            ->update([
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
            ]);
        if ($update) {
            return Redirect('viewSuratTeguran')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewSuratTeguran')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function indexSuratDispensasi(Request $request)
    {
        return view('surat.indexSuratDispensasi');
    }

    public function createSuratDispensasi()
    {
        return view('surat.createSuratDispensasi');
    }

    public function storeSuratDispensasi(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $startDate = Carbon::parse($dari);
        $endDate = Carbon::parse($sampai);

        while ($startDate->lte($endDate)) {
            $siswa = DB::table('siswa')->where('kode_siswa',$request->kode_siswa)->first();
            $simpan = DB::table('surat_dispensasi')
            ->insert([
                'kode_siswa' => $request->kode_siswa,
                'kode_kelas' => $siswa->kode_kelas,
                'tanggal' => $startDate->toDateString(),
                'deskripsi' => $request->deskripsi,
                'kode_member' => Auth::user()->kode_member,
            ]);
            $startDate->addDay();
        }
        if ($simpan) {
            return Redirect('viewSuratDispensasi')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewSuratDispensasi')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function deleteSuratDispensasi(Request $request)
    {
        $hapus = DB::table('surat_dispensasi')->where('id', $request->id)->delete();
        if ($hapus) {
            return Redirect('viewSuratDispensasi')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewSuratDispensasi')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function editSuratDispensasi($id)
    {
        $surat_dispensasi = DB::table('surat_dispensasi')->where('surat_dispensasi.id', $id)->first();
        return view('surat.editSuratDispensasi', compact('surat_dispensasi'));
    }

    public function showSuratDispensasi(Request $request)
    {
        $nama_siswa = $request->nama_siswa;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $surat_dispensasi = DB::table('surat_dispensasi')
        ->join('siswa','surat_dispensasi.kode_siswa','siswa.kode_siswa')
        ->join('kelas','surat_dispensasi.kode_kelas','kelas.kode_kelas')
        ->whereRaw("MONTH(surat_dispensasi.tanggal) = '$bulan'")
        ->whereRaw("YEAR(surat_dispensasi.tanggal) = '$tahun'")
        ->when($nama_siswa, function ($query) use ($nama_siswa) {
            return $query->where('siswa.nama_siswa', 'LIKE', '%' . $nama_siswa . '%');
        })
        ->orderBy('surat_dispensasi.tanggal', 'DESC')
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('surat.showSuratDispensasi', compact('surat_dispensasi'));
    }

    public function updateSuratDispensasi(Request $request)
    {
        $update = DB::table('surat_dispensasi')
            ->where('id', $request->id)
            ->update([
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
            ]);
        if ($update) {
            return Redirect('viewSuratDispensasi')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewSuratDispensasi')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function viewSuratUndangan(Request $request)
    {
        return view('surat.viewSuratUndangan');
    }
}
