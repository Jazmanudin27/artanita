@extends('frontend.template')
@section('titlepage', 'Dashboard Kelas')
@section('contents')
    @php
        $kelasUser = Auth::guard('kelas')->user();
        $kodeKelas = $kelasUser->kode_kelas;
        $namaKelas = $kelasUser->nama_kelas;
        $jurusan = $kelasUser->jurusan;

        // Stats for this specific class
        $totalSiswa = DB::table('siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('status', 'Aktif')
            ->count();

        $siswaL = DB::table('siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('status', 'Aktif')
            ->where('jk', 'Laki-Laki')
            ->count();

        $siswaP = DB::table('siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('status', 'Aktif')
            ->where('jk', 'Perempuan')
            ->count();

        $today = date('Y-m-d');

        $hadirToday = DB::table('absensi_siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('tanggal', $today)
            ->where('status', 'H')
            ->count();

        $sakitToday = DB::table('absensi_siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('tanggal', $today)
            ->where('status', 'S')
            ->count();

        $izinToday = DB::table('absensi_siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('tanggal', $today)
            ->where('status', 'I')
            ->count();

        $alfaToday = DB::table('absensi_siswa')
            ->where('kode_kelas', $kodeKelas)
            ->where('tanggal', $today)
            ->where('status', 'A')
            ->count();
    @endphp

    <style>
        .kelas-card-hero {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            border-radius: 24px;
            padding: 24px;
            color: #ffffff;
            box-shadow: 0 12px 24px -6px rgba(37, 99, 235, 0.3);
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .kelas-card-hero::after {
            content: '';
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-grid-custom {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card-custom {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .menu-grid-kelas {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .menu-button-card {
            background: #ffffff;
            border: 1.5px solid #E2E8F0;
            border-radius: 20px;
            padding: 20px 16px;
            text-align: center;
            text-decoration: none;
            color: #0F172A;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .menu-button-card:active {
            transform: scale(0.96);
            background: #F8FAFC;
        }

        .menu-icon-circle {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }
    </style>

    <div id="appCapsule" class="p-3">
        <!-- Hero Section Kelas -->
        <div class="kelas-card-hero">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="hero-badge">Akun Penanggung Jawab Absensi</span>
                    <h1 class="text-white font-weight-bold mb-1" style="font-size: 24px;">{{ $namaKelas }}</h1>
                    <p class="text-white-50 mb-0" style="font-size: 13px;">Jurusan: {{ $jurusan ?: '-' }}</p>
                </div>
                <a href="{{ route('signOut') }}" class="btn btn-sm btn-light" style="border-radius: 12px; padding: 8px 12px;" title="Keluar">
                    <ion-icon name="log-out-outline" style="font-size: 20px; color: #DC2626;"></ion-icon>
                </a>
            </div>
        </div>

        <!-- Quick Stats Kelas -->
        <div class="stat-grid-custom">
            <div class="stat-card-custom">
                <div class="stat-icon-box" style="background: #EFF6FF; color: #2563EB;">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
                <div>
                    <div style="font-size: 11px; color: #64748B; font-weight: 600;">Total Siswa</div>
                    <div style="font-size: 18px; color: #0F172A; font-weight: 800;">{{ $totalSiswa }}</div>
                </div>
            </div>

            <div class="stat-card-custom">
                <div class="stat-icon-box" style="background: #ECFDF5; color: #059669;">
                    <ion-icon name="checkmark-done-circle-outline"></ion-icon>
                </div>
                <div>
                    <div style="font-size: 11px; color: #64748B; font-weight: 600;">Hadir Hari Ini</div>
                    <div style="font-size: 18px; color: #059669; font-weight: 800;">{{ $hadirToday }}</div>
                </div>
            </div>
        </div>

        <!-- Attendance Status Breakdown -->
        <div class="card mb-3 p-3" style="border-radius: 18px; border: 1px solid #E2E8F0; background: #ffffff;">
            <div class="font-weight-bold text-dark mb-2" style="font-size: 13px;">Status Absensi Kelas Hari Ini ({{ date('d M Y') }})</div>
            <div class="d-flex justify-content-between text-center">
                <div class="flex-fill p-2" style="background: #ECFDF5; border-radius: 12px; margin-right: 4px;">
                    <div style="font-size: 11px; color: #065F46; font-weight: 600;">Hadir</div>
                    <div style="font-size: 16px; color: #059669; font-weight: 800;">{{ $hadirToday }}</div>
                </div>
                <div class="flex-fill p-2" style="background: #FEF3C7; border-radius: 12px; margin-right: 4px;">
                    <div style="font-size: 11px; color: #92400E; font-weight: 600;">Sakit</div>
                    <div style="font-size: 16px; color: #D97706; font-weight: 800;">{{ $sakitToday }}</div>
                </div>
                <div class="flex-fill p-2" style="background: #E0F2FE; border-radius: 12px; margin-right: 4px;">
                    <div style="font-size: 11px; color: #075985; font-weight: 600;">Izin</div>
                    <div style="font-size: 16px; color: #0284C7; font-weight: 800;">{{ $izinToday }}</div>
                </div>
                <div class="flex-fill p-2" style="background: #FEE2E2; border-radius: 12px;">
                    <div style="font-size: 11px; color: #991B1B; font-weight: 600;">Alfa</div>
                    <div style="font-size: 16px; color: #DC2626; font-weight: 800;">{{ $alfaToday }}</div>
                </div>
            </div>
        </div>

        <!-- Dedicated Menu Grid for Kelas -->
        <h3 class="font-weight-bold text-dark mb-2" style="font-size: 15px;">Menu Khusus Kelas {{ $namaKelas }}</h3>
        
        <div class="menu-grid-kelas">
            <!-- 1. Input/View Absensi Siswa Harian -->
            <a href="{{ route('viewAbsensiSiswa') }}" class="menu-button-card">
                <div class="menu-icon-circle" style="background: #DBEAFE; color: #2563EB;">
                    <ion-icon name="checkbox-outline"></ion-icon>
                </div>
                <span style="font-size: 13px; font-weight: 700;">Absensi Siswa</span>
                <span style="font-size: 11px; color: #64748B;">Input Harian Kelas</span>
            </a>

            <!-- 2. Rekap Absensi Siswa -->
            <a href="{{ route('rekapAbsensiSiswa') }}" class="menu-button-card">
                <div class="menu-icon-circle" style="background: #D1FAE5; color: #059669;">
                    <ion-icon name="stats-chart-outline"></ion-icon>
                </div>
                <span style="font-size: 13px; font-weight: 700;">Rekap Absensi</span>
                <span style="font-size: 11px; color: #64748B;">Laporan Bulanan</span>
            </a>

            <!-- 3. Absensi Per Mapel -->
            <a href="{{ route('viewAbsensiMapel') }}" class="menu-button-card">
                <div class="menu-icon-circle" style="background: #FEF3C7; color: #D97706;">
                    <ion-icon name="book-outline"></ion-icon>
                </div>
                <span style="font-size: 13px; font-weight: 700;">Absensi Mapel</span>
                <span style="font-size: 11px; color: #64748B;">Mata Pelajaran</span>
            </a>

            <!-- 4. Daftar Siswa Kelas -->
            <a href="{{ route('viewSiswa') }}" class="menu-button-card">
                <div class="menu-icon-circle" style="background: #F3E8FF; color: #9333EA;">
                    <ion-icon name="person-group-outline"></ion-icon>
                </div>
                <span style="font-size: 13px; font-weight: 700;">Siswa Kelas</span>
                <span style="font-size: 11px; color: #64748B;">Data Siswa {{ $namaKelas }}</span>
            </a>
        </div>
    </div>
@endsection
