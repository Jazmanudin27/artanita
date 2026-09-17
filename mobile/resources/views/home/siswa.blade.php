@extends('frontend.template')
@section('titlepage', 'Dashboard')
@section('contents')
    @php
        $pengajar = DB::table('guru')->where('status', 'Aktif')->count();
        $alumni = DB::table('siswa')->where('status', 'Alumni')->count();
        $siswaLakiLaki = DB::table('siswa')->where('status', 'Aktif')->where('jk', 'Laki-Laki')->count();
        $siswaPerempuan = DB::table('siswa')->where('status', 'Aktif')->where('jk', 'Perempuan')->count();
        $absensi = DB::table('absensi_siswa')
            ->where('kode_siswa', Auth::guard('siswa')->user()->kode_siswa)
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->get();
        $izin = DB::table('absensi_siswa')
            ->where('status', 'I')
            ->where('kode_siswa', Auth::guard('siswa')->user()->kode_siswa)
            ->whereMonth('tanggal', Date('m'))
            ->whereYear('tanggal', Date('Y'))
            ->count();
        $sakit = DB::table('absensi_siswa')
            ->where('status', 'S')
            ->where('kode_siswa', Auth::guard('siswa')->user()->kode_siswa)
            ->whereMonth('tanggal', Date('m'))
            ->whereYear('tanggal', Date('Y'))
            ->count();
        $alfa = DB::table('absensi_siswa')
            ->where('status', 'A')
            ->where('kode_siswa', Auth::guard('siswa')->user()->kode_siswa)
            ->whereMonth('tanggal', Date('m'))
            ->whereYear('tanggal', Date('Y'))
            ->count();
    @endphp
    <div id="appCapsule">
        <div class="">
            <div class="wallet-card">
                <div class="balance">
                    <div class="left">
                        <img src="{{ asset('assets/img/icon/pria.png') }}" alt="Avatar" class="avatar">
                        <div>
                            <span class="title">Selamat datang,</span>
                            <h1 class="total">{{ Auth::guard('siswa')->user()->nama_siswa }}</h1>
                        </div>
                    </div>
                    <div class="right">
                        <a href="{{ route('signOut') }}" class="button">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </a>
                    </div>
                </div>
                <div class="wallet-footer">
                    <div class="item">
                        <a href="#">
                            <div class="icon-wrapper bg-danger">
                                <img src="{{ 'assets/img/icon/sakit.png' }}" class="icon-menu">
                                @if ($sakit != 0)
                                    <span class="badge">{{ $sakit }}</span>
                                @endif
                            </div>
                            <strong>Sakit</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <div class="icon-wrapper bg-warning">
                                <img src="{{ 'assets/img/icon/izin.png' }}" class="icon-menu">
                                @if ($izin != 0)
                                    <span class="badge">{{ $izin }}</span>
                                @endif
                            </div>
                            <strong>Izin</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <div class="icon-wrapper bg-info">
                                <img src="{{ 'assets/img/icon/cuti.png' }}" class="icon-menu">
                                @if ($alfa != 0)
                                    <span class="badge">{{ $alfa }}</span>
                                @endif
                            </div>
                            <strong>Alfa</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="section full mt-2">
            <div class="menu">
                <a href="{{ route('viewSiswa') }}">
                    <img src="{{ 'assets/img/icon/3.png' }}" class="icon-menu">
                    <span>Siswa</span>
                </a>
                <a href="#">
                    <img src="{{ 'assets/img/icon/2.png' }}" class="icon-menu">
                    <span>Pengajar</span>
                </a>
                <a href="#">
                    <img src="{{ 'assets/img/icon/5.png' }}" class="icon-menu">
                    <span>Mapel</span>
                </a>
                <a href="#">
                    <img src="{{ 'assets/img/icon/7.png' }}" class="icon-menu">
                    <span>History</span>
                </a>
                <a href="{{ route('viewAbsensiSiswa') }}">
                    <img src="{{ 'assets/img/icon/8.png' }}" class="icon-menu">
                    <span>Absen Siswa</span>
                </a>
                <a href="#">
                    <img src="{{ 'assets/img/icon/6.png' }}" class="icon-menu">
                    <span>Absen Mapel</span>
                </a>
                <a href="{{ route('rekapAbsensiSiswa') }}">
                    <img src="{{ asset('assets/img/icon/7.png') }}" class="icon-menu">
                    <span>Rekap Siswa</span>
                </a>
                <a href="{{ route('rekapAbsensiMapel') }}">
                    <img src="{{ asset('assets/img/icon/5.png') }}" class="icon-menu">
                    <span>Rekap Mapel</span>
                </a>
            </div>
        </div>
    </div>
    <br>
@endsection
