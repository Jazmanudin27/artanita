@extends('frontend.template')
@section('titlepage', 'Dashboard')
@section('contents')
    @php
        $pengajar = DB::table('guru')->where('status', 'Aktif')->count();
        $alumni = DB::table('siswa')->where('status', 'Alumni')->count();
        $siswaLakiLaki = DB::table('siswa')->where('status', 'Aktif')->where('jk', 'Laki-Laki')->count();
        $siswaPerempuan = DB::table('siswa')->where('status', 'Aktif')->where('jk', 'Perempuan')->count();
        $absensi = DB::table('presensi')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->get();
        $scanToDay = DB::table('presensi')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->where('tanggal', Date('Y-m-d'))
            ->first();
        $hadir = DB::table('presensi')
            ->where('jam_in', '!=', '')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->whereMonth('tanggal', Date('m'))
            ->whereYear('tanggal', Date('Y'))
            ->count();
        $izin = DB::table('surat_absen')
            ->where('jenis_absen', 'Izin')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->whereMonth('tanggal', Date('m'))
            ->whereYear('tanggal', Date('Y'))
            ->count();
        $sakit = DB::table('surat_absen')
            ->where('jenis_absen', 'Sakit')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->whereMonth('tanggal', Date('m'))
            ->whereYear('tanggal', Date('Y'))
            ->count();
        $cuti = DB::table('surat_absen')
            ->where('jenis_absen', 'Cuti')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
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
                            <h1 class="total">{{ Auth::guard('guru')->user()->nama_guru }}</h1>
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
                            <div class="icon-wrapper bg-success">
                                <img src="{{ 'assets/img/icon/hadir.png' }}" class="icon-menu">
                                @if ($hadir != 0)
                                    <span class="badge">{{ $hadir }}</span>
                                @endif
                            </div>
                            <strong>Hadir</strong>
                        </a>
                    </div>
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
                                @if ($cuti != 0)
                                    <span class="badge">{{ $cuti }}</span>
                                @endif
                            </div>
                            <strong>Cuti</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="row mt-2">
                <div class="col-6">
                    <div class="stat-box bg-success">
                        <ion-icon name="finger-print" class="icon"></ion-icon>
                        <div class="title">Scan Masuk</div>
                        <div class="value">{{ $scanToDay->jam_in ?? 'Belum Scan' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box bg-danger">
                        <ion-icon name="finger-print" class="icon"></ion-icon>
                        <div class="title">Scan Pulang</div>
                        <div class="value">{{ $scanToDay->jam_out ?? 'Belum Scan' }}</div>
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
                <a href="{{ route('viewGuru') }}">
                    <img src="{{ 'assets/img/icon/2.png' }}" class="icon-menu">
                    <span>Pengajar</span>
                </a>
                <a href="{{ route('viewMapel') }}">
                    <img src="{{ 'assets/img/icon/5.png' }}" class="icon-menu">
                    <span>Mapel</span>
                </a>
                <a href="{{ route('viewPresensi') }}">
                    <img src="{{ 'assets/img/icon/7.png' }}" class="icon-menu">
                    <span>History</span>
                </a>
                <a href="{{ route('viewAbsensiSiswa') }}">
                    <img src="{{ 'assets/img/icon/8.png' }}" class="icon-menu">
                    <span>Absen Siswa</span>
                </a>
                <a href="{{ route('viewAbsensiMapel') }}">
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

        <div class="section mt-1 mb-5">
            <div class="section-heading">
                <h2 class="title">Histori 5 Hari Terakhir</h2>
                <a href="{{ route('viewPresensi') }}" class="link">View All</a>
            </div>
            <div class="transactions">
                @foreach ($absensi as $a)
                    <a href="#" class="item">
                        <div class="detail">
                            <ion-icon name="finger-print" class="icon"
                                style="font-size: 35px;padding-right:15px"></ion-icon>
                            <div>
                                <strong>{{ strftime('%A, %e %B %Y', strtotime($a->tanggal)) }}</strong>
                                <span style="color: {{ $a->jam_in ?: 'red' }}">{{ $a->jam_in ?: 'Belum Scan' }} - </span>
                                <span style="color: {{ $a->jam_out ?: 'red' }}">{{ $a->jam_out ?: 'Belum Scan' }}</span>
                            </div>
                        </div>
                        <div class="right">
                            <div class="price text-danger"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <br>
@endsection
