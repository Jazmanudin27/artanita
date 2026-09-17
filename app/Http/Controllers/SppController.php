<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class SppController extends Controller
{
    public function index(Request $request)
    {
        return view('spp.index');
    }

    public function create()
    {
        $siswa = DB::table('siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->where('siswa.kode_member', Auth::user()->kode_member)
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        return view('spp.create',compact('siswa'));
    }

    public function showSppTemp(Request $request)
    {
        $kode_siswa     = $request->kode_siswa;

        $spp = DB::table('spp_temp')
        ->join('siswa','siswa.kode_siswa','spp_temp.kode_siswa')
        ->where('spp_temp.kode_siswa',$kode_siswa)
        ->orderBy('spp_temp.bulan', 'ASC')
        ->orderBy('spp_temp.tahun', 'ASC')
        ->get();
        return view('spp.showSppTemp', compact('spp'));
    }
    public function show(Request $request)
    {
        $spp = DB::table('spp')
        ->join('siswa','siswa.kode_siswa','spp.kode_siswa')
        ->join('kelas','kelas.kode_kelas','spp.kode_kelas')
        ->join('users','users.id','spp.kode_user')
        ->where('spp.kode_member', Auth::user()->kode_member)
        ->orderBy('spp.tanggal', 'ASC')
        ->get();
        return view('spp.show', compact('spp'));
    }

    public function nobuktiSpp()
    {
        $kode_member = Auth::user()->kode_member;
        $tanggal = date('ymd');
        $latestInvoiceNumber = DB::table('spp')
            ->select('nobukti')
            ->orderBy('nobukti', 'desc')
            ->value('nobukti');
        if ($latestInvoiceNumber) {
            $lastInvoiceDate = substr($latestInvoiceNumber, 5, 6);
            if ($lastInvoiceDate == $tanggal) {
                $lastInvoiceNumber = intval(substr($latestInvoiceNumber, -4));
                $nextInvoiceNumber = str_pad($lastInvoiceNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextInvoiceNumber = '0001';
            }
        } else {
            $nextInvoiceNumber = '0001';
        }
        return $kode_member . $tanggal . $nextInvoiceNumber;
    }
    public function storeSpp(Request $request)
    {
        DB::table('spp')
        ->insert([
            'nobukti' => $request->nobukti,
            'tanggal' => $request->tanggal,
            'kode_siswa' => $request->kode_siswa,
            'kode_kelas' => $request->kode_kelas,
            'kode_tahun_pelajaran' => $request->kode_tahun_pelajaran,
            'kode_user' => Auth::user()->id,
            'kode_member' => Auth::user()->kode_member,
            'created_at' => Date('Y-m-d h:i:s'),
        ]);

        $siswa =  DB::table('spp_temp')->where('kode_siswa',$request->kode_siswa)->get();
        foreach ($siswa as $key => $s) {
            DB::table('spp_detail')
            ->insert([
                'nobukti' => $request->nobukti,
                'kode_kelas' => $s->kode_kelas,
                'kode_siswa' => $s->kode_siswa,
                'tahun' => $s->tahun,
                'jumlah' => $s->jumlah,
            ]);
        }
        DB::table('spp_temp')->where('kode_siswa',$request->kode_siswa)->delete();
    }
    public function cekSppTemp(Request $request)
    {
        $kode_siswa     = $request->kode_siswa;
        $bulan          = $request->bulan;
        $tahun          = $request->tahun;
        $kode_kelas     = $request->kode_kelas;

        return DB::table('spp_temp')
        ->where('spp_temp.kode_siswa',$kode_siswa)
        ->where('spp_temp.bulan',$bulan)
        ->where('spp_temp.tahun',$tahun)
        ->where('spp_temp.kode_kelas',$kode_kelas)
        ->count();
    }

    public function storeSppTemp(Request $request)
    {
        DB::table('spp_temp')
        ->insert([
            'kode_siswa' => $request->kode_siswa,
            'kode_kelas' => $request->kode_kelas,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => str_replace(",","",$request->jumlah),
        ]);
    }

    public function deleteSppTemp(Request $request)
    {
        DB::table('spp_temp')->where('id',$request->id)->delete();
    }
    public function cetakFakturSpp(Request $request)
    {
        $spp = DB::table('spp')
        ->join('tahun_pelajaran','tahun_pelajaran.kode_tahun_pelajaran','spp_temp.kode_tahun_pelajaran')
        ->join('users','users.id','spp_temp.kode_user')
        ->where('nobukti', $request->id)->first();

        $detail = DB::table('spp_detail')
        ->where('nobukti', $request->id)->get();
        return view('spp.cetakFakturSpp',compact('spp','detail'));
    }

}
