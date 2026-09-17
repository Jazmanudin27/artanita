<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        return view('peminjaman.index');
    }

    public function create()
    {
        $buku = DB::table('buku')
        ->where('buku.kode_member', Auth::user()->kode_member)
        ->orderBy('buku.judul', 'ASC')
        ->get();
        return view('peminjaman.create', compact('buku'));
    }

    public function store(Request $request)
    {
        $simpan = DB::table('peminjaman')
            ->insert([
                'kode_buku' => $request->kode_buku,
                'kode_siswa' => $request->kode_siswa,
                'tanggal' => $request->tanggal,
                'tgl_kembali' => $request->tgl_kembali,
                'kode_member' => Auth::user()->kode_member,
            ]);
            DB::table('buku')->where('kode_buku', $request->kode_buku)->update(
                [
                    'sisa_stok' => $request->stok - 1
                ]
            );
        if ($simpan) {
            return Redirect('viewPeminjaman')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect('viewPeminjaman')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function delete(Request $request)
    {
        $hapus = DB::table('peminjaman')->where('id', $request->id)->delete();
        DB::table('buku')->where('kode_buku', $request->kode_buku)->update(
            [
                'sisa_stok' => $request->stok + 1
            ]
        );
        if ($hapus) {
            return Redirect('viewPeminjaman')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect('viewPeminjaman')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function edit(Request $request)
    {
        $buku = DB::table('buku')
        ->orderBy('buku.judul', 'ASC')
        ->get();
        $peminjaman = DB::table('peminjaman')
        ->join('buku','buku.kode_buku','peminjaman.kode_buku')
        ->where('peminjaman.id', $request->id)->first();
        return view('peminjaman.edit', compact('peminjaman','buku'));
    }

    public function show(Request $request)
    {
        $nama_siswa = $request->nama_siswa;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $status = $request->status;
        if($status == 1){
            $statusDikembalikan = "peminjaman.tgl_dikembalikan Is Null";
        }elseif($status == 2){
            $statusDikembalikan = "peminjaman.tgl_dikembalikan != ''";
        }else{
            $statusDikembalikan = "peminjaman.tgl_dikembalikan != '' OR peminjaman.tgl_dikembalikan Is Null";
        }
        $peminjaman = DB::table('peminjaman')
        ->join('siswa','siswa.kode_siswa','peminjaman.kode_siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->join('buku','buku.kode_buku','peminjaman.kode_buku')
        ->when($nama_siswa, function ($query) use ($nama_siswa) {
            return $query->where('siswa.nama_siswa', 'LIKE', '%' . $nama_siswa . '%');
        }
        )->when($statusDikembalikan, function ($query) use ($statusDikembalikan) {
            return $query->whereRaw($statusDikembalikan);
        })
        ->when($bulan, function ($query) use ($bulan) {
            return $query->whereRaw("MONTH(peminjaman.tgl_kembali) = '$bulan' ");
        })
        ->when($tahun, function ($query) use ($tahun) {
            return $query->whereRaw("YEAR(peminjaman.tgl_kembali) = '$tahun' ");
        })
        ->orderBy('peminjaman.tanggal', 'DESC')
        ->get();
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function update(Request $request)
    {

        $peminjaman = DB::table('peminjaman')
        ->join('buku','buku.kode_buku','peminjaman.kode_buku')
        ->where('peminjaman.id', $request->id)->first();
        $buku = DB::table('buku')
        ->where('buku.kode_buku', $request->kode_buku)->first();
        if($peminjaman->kode_buku != $request->kode_buku){
            DB::table('buku')->where('kode_buku', $peminjaman->kode_buku)->update(
                [
                    'sisa_stok' => $peminjaman->sisa_stok + 1
                ]
            );
            DB::table('buku')->where('kode_buku', $request->kode_buku)->update(
                [
                    'sisa_stok' => $buku->sisa_stok - 1
                ]
            );
        }
        $update = DB::table('peminjaman')
            ->where('id', $request->id)
            ->update([
                'kode_buku' => $request->kode_buku,
                'kode_siswa' => $request->kode_siswa,
                'tanggal' => $request->tanggal,
                'tgl_kembali' => $request->tgl_kembali,
            ]);
        if ($update) {
            return Redirect('viewPeminjaman')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewPeminjaman')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function pengembalianBuku(Request $request)
    {
        $update = DB::table('peminjaman')
            ->where('id', $request->id)
            ->update([
                'tgl_dikembalikan' => $request->tgl_dikembalikan,
            ]);
            DB::table('buku')->where('kode_buku', $request->kode_buku)->update(
                [
                    'sisa_stok' => $request->stok + 1
                ]
            );
        if ($update) {
            return Redirect('viewPeminjaman')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewPeminjaman')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function batalDikembalikan(Request $request)
    {
        $update = DB::table('peminjaman')
            ->where('id', $request->id)
            ->update([
                'tgl_dikembalikan' => NULL,
            ]);
            DB::table('buku')->where('kode_buku', $request->kode_buku)->update(
                [
                    'sisa_stok' => $request->stok - 1
                ]
            );
        if ($update) {
            return Redirect('viewPeminjaman')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewPeminjaman')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function perpanjangPeminjaman(Request $request)
    {
        $update = DB::table('peminjaman')
            ->where('id', $request->id_peminjaman)
            ->update([
                'tgl_kembali' => $request->tgl_kembali,
            ]);
        if ($update) {
            return Redirect('viewPeminjaman')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect('viewPeminjaman')->with(['warning' => 'Data Gagal Diupdate']);
        }
    }
}
