<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LaporanController extends Controller
{
    public function laporanSiswa()
    {
        return view('laporan.laporanSiswa');
    }

    public function cetakLaporanSiswa(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $status = $request->status;

        $kelas = DB::table('kelas')
        ->where('kelas.kode_kelas', $kode_kelas)->first();

        $laporan = DB::table('siswa')
        ->selectRaw('nama_kelas,nama_siswa,siswa.no_hp,siswa.alamat,siswa.tgl_lahir,tempat_lahir,siswa.jk,siswa.status')
        ->join('kelas','siswa.kode_kelas','kelas.kode_kelas')
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('siswa.kode_kelas', $kode_kelas);
        })
        ->when($status, function ($query) use ($status) {
            return $query->where('siswa.status', $status);
        })
        ->orderBy('kelas.nama_kelas', 'ASC')
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();
        if (isset($_POST['export'])) {
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=Laporan Data Siswa.xls");
		}
        return view('laporan.cetakLaporanSiswa', compact('laporan','kode_kelas','kelas'));
    }

    public function laporanGuru()
    {
        return view('laporan.laporanGuru');
    }

    public function cetakLaporanGuru(Request $request)
    {
        $kode_guru = $request->kode_guru;

        $guru = DB::table('guru')
        ->where('guru.kode_guru', $kode_guru)->first();

        $laporan = DB::table('guru')
        ->selectRaw('nama_guru,guru.no_hp,guru.alamat,guru.tgl_lahir,tempat_lahir,guru.jk,guru.status')
        ->when($kode_guru, function ($query) use ($kode_guru) {
            return $query->where('guru.kode_guru', $kode_guru);
        })
        ->orderBy('guru.nama_guru', 'ASC')
        ->get();
        if (isset($_POST['export'])) {
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=Laporan Data Guru.xls");
		}
        return view('laporan.cetakLaporanGuru', compact('laporan','kode_guru','guru'));
    }

    public function laporanPresensi()
    {
        return view('laporan.laporanPresensi');
    }

    public function cetakLaporanPresensi(Request $request)
    {
        $jenis_laporan = $request->input('jenis_laporan');
        if($jenis_laporan == 'Standar'){
              
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
        
            // Validasi input
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'jenis_laporan' => 'required|in:Standar,Detail,Rekap',
            ]);
        
            // Mengambil daftar guru
            $guruList = DB::table('guru')
                ->orderBy('nama_guru', 'ASC')
                ->get();
        
            // Membuat daftar tanggal dalam rentang
            $start = Carbon::parse($start_date);
            $end = Carbon::parse($end_date);
            $period = CarbonPeriod::create($start, $end);
            $dates = [];
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            $jmlhTanggal = count($dates);
        
            // Mengambil data presensi semua guru dalam rentang tanggal
            $presensiData = DB::table('presensi')
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->get()
                ->groupBy('kode_guru');
        
            // Mengambil data surat absen semua guru dalam rentang tanggal
            $suratAbsenData = DB::table('surat_absen')
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->get()
                ->groupBy('kode_guru');
        
            // Menyiapkan data laporan
            $laporan = $guruList->map(function($guru) use ($dates, $presensiData, $suratAbsenData) {
                $kode_guru = $guru->kode_guru;
                $presensi = $presensiData->get($kode_guru, collect());
                $absensi = $suratAbsenData->get($kode_guru, collect());
        
                $presensiMap = $presensi->keyBy('tanggal');
                $absensiMap = $absensi->keyBy('tanggal');
        
                // Menyiapkan status harian
                $days = [];
                foreach ($dates as $date) {
                    if ($presensiMap->has($date) && !empty($presensiMap->get($date)->jam_out)) {
                        $days[] = 'H'; // Hadir
                    } elseif ($absensiMap->has($date)) {
                        $days[] = $absensiMap->get($date)->jenis_absen;
                    } else {
                        $days[] = ''; // Tidak ada data
                    }
                }
        
                // Menghitung jenis absensi
                $sakit = $absensi->where('jenis_absen', 'Sakit')->count();
                $izin = $absensi->where('jenis_absen', 'Izin')->count();
                $cuti = $absensi->where('jenis_absen', 'Cuti')->count();
        
                return (object) [
                    'nama_guru' => strtoupper($guru->nama_guru),
                    'days' => $days,
                    'Izin' => $izin,
                    'Sakit' => $sakit,
                    'Cuti' => $cuti,
                ];
            });
        
            // Mengatur header untuk export Excel jika diminta
            if ($request->has('export')) {
                $filename = "Laporan_Presensi_Guru_{$start_date}_sampai_{$end_date}.xls";
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename={$filename}");
            }
        
            return view('laporan.cetakLaporanPresensi', compact('laporan', 'jenis_laporan', 'start_date', 'end_date', 'dates', 'jmlhTanggal'));
        }else if($jenis_laporan == 'Detail'){
               // Ambil data dari input form
            $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // Validasi input
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'jenis_laporan' => 'required|in:Standar,Detail,Rekap',
    ]);

    // Mengambil daftar guru
    $guruList = DB::table('guru')
        ->orderBy('nama_guru', 'ASC')
        ->get();

    // Membuat daftar tanggal dalam rentang
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($end_date);
    $period = CarbonPeriod::create($start, $end);
    $dates = [];
    foreach ($period as $date) {
        $dates[] = $date->format('Y-m-d');
    }
    $jmlhTanggal = count($dates);

    // Mengambil data presensi semua guru dalam rentang tanggal
    $presensiData = DB::table('presensi')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->get()
        ->groupBy('kode_guru');

    // Mengambil data surat absen semua guru dalam rentang tanggal
    $suratAbsenData = DB::table('surat_absen')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->get()
        ->groupBy('kode_guru');

    // Menyiapkan data laporan
    $laporan = $guruList->map(function($guru) use ($dates, $presensiData, $suratAbsenData) {
        $kode_guru = $guru->kode_guru;
        $presensi = $presensiData->get($kode_guru, collect());
        $absensi = $suratAbsenData->get($kode_guru, collect());

        $presensiMap = $presensi->keyBy('tanggal');
        $absensiMap = $absensi->keyBy('tanggal');

        // Menyiapkan status harian, menampilkan jam masuk dan keluar
        $days = [];
        foreach ($dates as $date) {
            if ($presensiMap->has($date)) {
                $presensiHari = $presensiMap->get($date);
                $jam_in = $presensiHari->jam_in ? substr($presensiHari->jam_in, 0, 5) : ''; // Format hh:mm
                $jam_out = $presensiHari->jam_out ? substr($presensiHari->jam_out, 0, 5) : ''; // Format hh:mm

                // Mengatur warna teks (hitam jika ada jam_in dan jam_out, merah jika tidak ada)
                $color = ($jam_in && $jam_out) ? '#000' : '#ff0000';

                $days[] = [
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'color' => $color
                ];
            } elseif ($absensiMap->has($date)) {
                // Jika absen, masukkan jenis absensi (izin, sakit, cuti)
                $days[] = [
                    'jam_in' => $absensiMap->get($date)->jenis_absen,
                    'jam_out' => '',
                    'color' => '#0000ff' // Biru untuk absen
                ];
            } else {
                // Tidak ada data
                $days[] = [
                    'jam_in' => '',
                    'jam_out' => '',
                    'color' => '#ff0000' // Merah untuk tidak hadir
                ];
            }
        }

        // Menghitung jenis absensi
        $sakit = $absensi->where('jenis_absen', 'Sakit')->count();
        $izin = $absensi->where('jenis_absen', 'Izin')->count();
        $cuti = $absensi->where('jenis_absen', 'Cuti')->count();

        return (object) [
            'nama_guru' => strtoupper($guru->nama_guru),
            'days' => $days,
            'Izin' => $izin,
            'Sakit' => $sakit,
            'Cuti' => $cuti,
        ];
    });

    // Kirim data ke view
    return view('laporan.cetakLaporanDetailPresensi', compact('laporan', 'dates', 'jmlhTanggal', 'start_date', 'end_date'));
        }else if($jenis_laporan == 'Rekap'){
            if (isset($_POST['export'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan Presensi Rekap Guru.xls");
            }
            return view('laporan.cetakLaporanRekapPresensi', compact('laporan','bulan','tahun'));
        }
    }

    public function LaporanAbsensiSiswa()
    {
        return view('laporan.laporanAbsensiSiswa');
    }

    public function cetakLaporanAbsensiSiswa(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $jenis_laporan = $request->jenis_laporan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $kelas = DB::table('kelas')
        ->where('kelas.kode_kelas', $kode_kelas)->first();
        $laporan = DB::table('siswa')
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('siswa.kode_kelas', $kode_kelas);
        })
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();

        if($jenis_laporan == 'Standar'){
            if (isset($_POST['export'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan Absensi Siswa.xls");
            }
            return view('laporan.cetakLaporanAbsensiSiswa', compact('laporan','kode_kelas','kelas','bulan','tahun'));
        }else if($jenis_laporan == 'Rekap'){
            if (isset($_POST['export'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan Presensi Rekap Absensi Siswa.xls");
            }
            return view('laporan.cetakLaporanRekapAbsensiSiswa', compact('laporan','kode_kelas','kelas','bulan','tahun'));
        }
    }

    public function LaporanAbsensiMapel()
    {
        return view('laporan.laporanAbsensiMapel');
    }

    public function cetakLaporanAbsensiMapel(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $kode_mapel = $request->kode_mapel;
        $jenis_laporan = $request->jenis_laporan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $kelas = DB::table('kelas')
        ->where('kelas.kode_kelas', $kode_kelas)->first();
        $mapel = DB::table('mapel')
        ->where('mapel.kode_mapel', $kode_mapel)->first();
        $laporan = DB::table('siswa')
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('siswa.kode_kelas', $kode_kelas);
        })
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();

        if($jenis_laporan == 'Standar'){
            if (isset($_POST['export'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan Absensi Mapel.xls");
            }
            return view('laporan.cetakLaporanAbsensiMapel', compact('laporan','kode_kelas','kode_mapel','kelas','mapel','bulan','tahun'));
        }else if($jenis_laporan == 'Rekap'){
            if (isset($_POST['export'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan Presensi Rekap Absensi Mapel.xls");
            }
            return view('laporan.cetakLaporanRekapAbsensiMapel', compact('laporan','kode_kelas','kode_mapel','kelas','mapel','bulan','tahun'));
        }
    }

    public function laporanSuratAbsen()
    {
        return view('laporan.laporanSuratAbsen');
    }

    public function cetakLaporanSuratAbsen(Request $request)
    {
        $kode_guru = $request->kode_guru;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $laporan = DB::table('surat_absen')
        ->selectRaw('nama_guru,surat_absen.tanggal,surat_absen.deskripsi,surat_absen.status,jenis_absen')
        ->join('guru','guru.kode_guru','surat_absen.kode_guru')
        ->whereRaw("MONTH(tanggal) = '$bulan'")
        ->whereRaw("YEAR(tanggal) = '$tahun'")
        ->when($kode_guru, function ($query) use ($kode_guru) {
            return $query->where('surat_absen.kode_guru', $kode_guru);
        })
        ->orderBy('surat_absen.tanggal', 'DESC')
        ->orderBy('guru.nama_guru', 'ASC')
        ->get();

        if (isset($_POST['export'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Surat Absen.xls");
        }
        return view('laporan.cetakLaporanSuratAbsen', compact('laporan','kode_guru','tahun','bulan'));
    }


    public function laporanSuratTeguran()
    {
        return view('laporan.laporanSuratTeguran');
    }

    public function cetakLaporanSuratTeguran(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $tahun = $request->tahun;
        $bulan = $request->bulan;


        $kelas = DB::table('kelas')
        ->where('kelas.kode_kelas', $kode_kelas)->first();
        $laporan = DB::table('teguran')
        ->selectRaw('nis,nama_siswa,teguran.tanggal,teguran.deskripsi,nama_kelas')
        ->join('siswa','siswa.kode_siswa','teguran.kode_siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->whereRaw("MONTH(tanggal) = '$bulan'")
        ->whereRaw("YEAR(tanggal) = '$tahun'")
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('siswa.kode_kelas', $kode_kelas);
        })
        ->orderBy('teguran.tanggal', 'DESC')
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();

        if (isset($_POST['export'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Surat Teguran.xls");
        }
        return view('laporan.cetakLaporanSuratTeguran', compact('laporan','kode_kelas','kelas','tahun','bulan'));
    }

    public function laporanSuratDispensasi()
    {
        return view('laporan.laporanSuratDispensasi');
    }

    public function cetakLaporanSuratDispensasi(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $kelas = DB::table('kelas')
        ->where('kelas.kode_kelas', $kode_kelas)->first();
        $laporan = DB::table('surat_dispensasi')
        ->selectRaw('nis,nama_siswa,surat_dispensasi.tanggal,surat_dispensasi.deskripsi,nama_kelas')
        ->join('siswa','siswa.kode_siswa','surat_dispensasi.kode_siswa')
        ->join('kelas','kelas.kode_kelas','siswa.kode_kelas')
        ->whereRaw("MONTH(tanggal) = '$bulan'")
        ->whereRaw("YEAR(tanggal) = '$tahun'")
        ->when($kode_kelas, function ($query) use ($kode_kelas) {
            return $query->where('siswa.kode_kelas', $kode_kelas);
        })
        ->orderBy('surat_dispensasi.tanggal', 'DESC')
        ->orderBy('siswa.nama_siswa', 'ASC')
        ->get();

        if (isset($_POST['export'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Surat Dispensasi.xls");
        }
        return view('laporan.cetakLaporanSuratDispensasi', compact('laporan','kode_kelas','kelas','tahun','bulan'));
    }

    public function laporanSapras()
    {
        return view('laporan.laporanSapras');
    }

    public function cetakLaporanSapras(Request $request)
    {
        if (isset($_POST['export'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Sarana & Prasarana.xls");
        }
        return view('laporan.cetakLaporanSapras');
    }

    public function laporanJadwal()
    {
        return view('laporan.laporanJadwal');
    }

    public function cetakLaporanJadwal(Request $request)
    {
        $kode_member    = Auth::user()->kode_member;
        $hari           = $request->hari;

        $member = DB::table('member')
        ->where('member.kode_member',$kode_member)
        ->first();

        $jamKe = DB::table('jadwal_jam')
        ->selectRaw("kode_jam,jam_ke,jam")
        ->get();

        $kelas = DB::table('kelas')
            ->orderBy('nama_kelas','ASC')
            ->where('kode_member', $kode_member)
            ->get();

        $jmlKelas = DB::table('kelas')
            ->orderBy('nama_kelas','ASC')
            ->where('kode_member', $kode_member)
            ->count();

        $guru = DB::table('guru')
            ->where('kode_member', $kode_member)
            ->orderBy('nama_guru','ASC')
            ->get();

        return view('laporan.cetakLaporanJadwal', compact('member','kelas','jmlKelas','guru','jamKe','hari'));
    }

    public function selectKelas(Request $request)
    {
        $kode_kelas = $request->kode_kelas;
        $siswa = DB::table('siswa')
        ->where('kode_kelas', $kode_kelas)
        ->orderBy('nama_siswa','ASC')
        ->get();
        return response()->json($siswa);
    }
}
