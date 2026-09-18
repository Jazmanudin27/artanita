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

        $sudahAbsenCount = $hadirToday + $sakitToday + $izinToday + $alfaToday;
        $persenAbsen = $totalSiswa > 0 ? round(($sudahAbsenCount / $totalSiswa) * 100) : 0;

        // Time-based Indonesian Greeting
        $hour = (int)date('H');
        if ($hour >= 3 && $hour < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Format Indonesian Date
        $days = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $months = ['01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'];
        $dayName = $days[date('l')];
        $monthName = $months[date('m')];
        $formattedDate = $dayName . ', ' . date('d') . ' ' . $monthName . ' ' . date('Y');
    @endphp

    <style>
        :root {
            --kelas-hero-bg: linear-gradient(135deg, #0F172A 0%, #1E3A8A 50%, #2563EB 100%);
            --accent-glow: rgba(59, 130, 246, 0.25);
        }

        body {
            background-color: #F8FAFC !important;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            color: #0F172A;
        }

        /* Hero Header */
        .kelas-hero-header {
            background: var(--kelas-hero-bg);
            padding: 32px 20px 56px 20px;
            border-bottom-right-radius: 36px;
            border-bottom-left-radius: 36px;
            color: #FFFFFF;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(30, 58, 138, 0.4);
        }

        .kelas-hero-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
        }

        .kelas-hero-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 160px;
            height: 160px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
        }

        .class-avatar-badge {
            width: 58px;
            height: 58px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #FFFFFF;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .btn-logout-pill {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #FFFFFF;
            border-radius: 24px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
            transition: all 0.25s ease;
        }

        .btn-logout-pill:hover, .btn-logout-pill:active {
            background: rgba(239, 68, 68, 0.9);
            border-color: rgba(239, 68, 68, 1);
            color: #FFFFFF;
            transform: translateY(-1px);
        }

        /* Container Layout */
        .kelas-container {
            max-width: 480px;
            margin: -36px auto 90px auto;
            padding: 0 18px;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
        }

        /* Floating Stat Card */
        .floating-stat-card {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 22px 20px;
            box-shadow: 0 16px 36px -10px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.9);
            margin-bottom: 20px;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background-color: #10B981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: pulse-dot 1.8s infinite;
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .progress-bar-bg {
            height: 8px;
            background: #F1F5F9;
            border-radius: 10px;
            overflow: hidden;
            margin: 14px 0 16px 0;
            display: flex;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #2563EB 0%, #3B82F6 100%);
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        /* Status Chips Grid */
        .status-chip-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .status-chip {
            padding: 12px 6px;
            border-radius: 18px;
            text-align: center;
            box-sizing: border-box;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .status-chip:hover {
            transform: translateY(-2px);
        }

        .chip-hadir { background: #ECFDF5; border: 1.5px solid #A7F3D0; color: #065F46; }
        .chip-sakit { background: #FEF3C7; border: 1.5px solid #FDE68A; color: #92400E; }
        .chip-izin { background: #E0F2FE; border: 1.5px solid #BAE6FD; color: #075985; }
        .chip-alfa { background: #FEE2E2; border: 1.5px solid #FECACA; color: #991B1B; }

        .chip-val {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.1;
        }

        .chip-lbl {
            font-size: 11px;
            font-weight: 700;
            margin-top: 3px;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Demographic Pill Bar */
        .info-pill-bar {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 14px 18px;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.03);
        }

        .info-pill-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .info-pill-divider {
            height: 18px;
            width: 1px;
            background: #E2E8F0;
        }

        /* Action Cards Section */
        .section-header-modern {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 4px 14px 4px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.2px;
            margin: 0;
        }

        .section-subtitle {
            font-size: 11px;
            color: #64748B;
            font-weight: 600;
            background: #F1F5F9;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .modern-action-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 18px 20px;
            border: 1.5px solid #F1F5F9;
            box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.04);
            margin-bottom: 14px;
            text-decoration: none !important;
            color: #0F172A !important;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .modern-action-card:hover, .modern-action-card:active {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -8px rgba(37, 99, 235, 0.15), 0 0 0 1.5px #2563EB;
            border-color: transparent;
            background: #FFFFFF;
        }

        .action-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.04);
        }

        .bg-icon-blue { background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); color: #2563EB; }
        .bg-icon-emerald { background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); color: #059669; }
        .bg-icon-amber { background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); color: #D97706; }
        .bg-icon-purple { background: linear-gradient(135deg, #F3E8FF 0%, #E9D5FF 100%); color: #9333EA; }

        .action-content {
            flex: 1;
        }

        .action-title {
            font-size: 15px;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 3px 0;
            line-height: 1.25;
        }

        .action-desc {
            font-size: 12px;
            color: #64748B;
            margin: 0;
            font-weight: 500;
            line-height: 1.3;
        }

        .action-arrow {
            color: #CBD5E1;
            font-size: 20px;
            transition: transform 0.25s ease, color 0.25s ease;
            flex-shrink: 0;
        }

        .modern-action-card:hover .action-arrow {
            color: #2563EB;
            transform: translateX(4px);
        }
    </style>

    <div id="appCapsule">
        <!-- Hero Header -->
        <div class="kelas-hero-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center" style="gap: 14px;">
                    <div class="class-avatar-badge">
                        <ion-icon name="easel-outline"></ion-icon>
                    </div>
                    <div>
                        <div style="font-size: 12px; opacity: 0.85; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ $greeting }} 👋
                        </div>
                        <h1 style="font-size: 22px; font-weight: 800; margin: 2px 0 0 0; line-height: 1.2; letter-spacing: -0.3px;">
                            {{ $namaKelas }}
                        </h1>
                        <div style="font-size: 11px; opacity: 0.8; font-weight: 500; margin-top: 3px;">
                            {{ $jurusan ?: 'SMK Artanita' }} • Penanggung Jawab Kelas
                        </div>
                    </div>
                </div>

                <a href="{{ route('signOut') }}" class="btn-logout-pill" title="Keluar dari akun">
                    <ion-icon name="log-out-outline" style="font-size: 16px;"></ion-icon>
                    <span>Keluar</span>
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="kelas-container">
            <!-- Floating Attendance Stat Card -->
            <div class="floating-stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <span class="live-dot"></span>
                        <span style="font-size: 14px; font-weight: 800; color: #0F172A;">Presensi Hari Ini</span>
                    </div>
                    <span class="badge" style="background: #EFF6FF; color: #2563EB; font-weight: 700; border-radius: 12px; padding: 5px 12px; font-size: 11px; border: 1px solid #DBEAFE;">
                        {{ $formattedDate }}
                    </span>
                </div>

                <!-- Progress Bar -->
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $persenAbsen }}%;"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 12px;">
                    <span style="color: #64748B; font-weight: 600;">Progres Presensi Siswa</span>
                    <span style="color: #0F172A; font-weight: 800;">{{ $sudahAbsenCount }} dari {{ $totalSiswa }} Siswa ({{ $persenAbsen }}%)</span>
                </div>

                <!-- Status Chips Grid -->
                <div class="status-chip-grid">
                    <div class="status-chip chip-hadir">
                        <div class="chip-val">{{ $hadirToday }}</div>
                        <div class="chip-lbl">Hadir</div>
                    </div>
                    <div class="status-chip chip-sakit">
                        <div class="chip-val">{{ $sakitToday }}</div>
                        <div class="chip-lbl">Sakit</div>
                    </div>
                    <div class="status-chip chip-izin">
                        <div class="chip-val">{{ $izinToday }}</div>
                        <div class="chip-lbl">Izin</div>
                    </div>
                    <div class="status-chip chip-alfa">
                        <div class="chip-val">{{ $alfaToday }}</div>
                        <div class="chip-lbl">Alfa</div>
                    </div>
                </div>
            </div>

            <!-- Student Demographics Info Bar -->
            <div class="info-pill-bar">
                <div class="info-pill-item">
                    <ion-icon name="people" style="font-size: 18px; color: #2563EB;"></ion-icon>
                    <span>Total: <strong style="color: #0F172A;">{{ $totalSiswa }}</strong></span>
                </div>
                <div class="info-pill-divider"></div>
                <div class="info-pill-item">
                    <ion-icon name="man" style="font-size: 18px; color: #0284C7;"></ion-icon>
                    <span>Laki-Laki: <strong style="color: #0F172A;">{{ $siswaL }}</strong></span>
                </div>
                <div class="info-pill-divider"></div>
                <div class="info-pill-item">
                    <ion-icon name="woman" style="font-size: 18px; color: #EC4899;"></ion-icon>
                    <span>Perempuan: <strong style="color: #0F172A;">{{ $siswaP }}</strong></span>
                </div>
            </div>

            <!-- Action Cards Section Header -->
            <div class="section-header-modern">
                <h2 class="section-title">Menu Utama Absensi</h2>
                <span class="section-subtitle">{{ $namaKelas }}</span>
            </div>

            <!-- Card 1: Absensi Siswa Harian -->
            <a href="{{ route('viewAbsensiSiswa') }}" class="modern-action-card">
                <div class="action-icon-badge bg-icon-blue">
                    <ion-icon name="checkbox-outline"></ion-icon>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Absensi Harian Siswa</h3>
                    <p class="action-desc">Input & kelola presensi harian {{ $namaKelas }}</p>
                </div>
                <ion-icon name="chevron-forward-outline" class="action-arrow"></ion-icon>
            </a>

            <!-- Card 2: Rekapitulasi Absensi -->
            <a href="{{ route('rekapAbsensiSiswa') }}" class="modern-action-card">
                <div class="action-icon-badge bg-icon-emerald">
                    <ion-icon name="bar-chart-outline"></ion-icon>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Rekap Presensi Bulanan</h3>
                    <p class="action-desc">Laporan akumulasi Hadir, Sakit, Izin, & Alfa</p>
                </div>
                <ion-icon name="chevron-forward-outline" class="action-arrow"></ion-icon>
            </a>

            <!-- Card 3: Absensi Per Mata Pelajaran -->
            <a href="{{ route('viewAbsensiMapel') }}" class="modern-action-card">
                <div class="action-icon-badge bg-icon-amber">
                    <ion-icon name="book-outline"></ion-icon>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Absensi Mata Pelajaran</h3>
                    <p class="action-desc">Log kehadiran siswa per jam mata pelajaran</p>
                </div>
                <ion-icon name="chevron-forward-outline" class="action-arrow"></ion-icon>
            </a>

            <!-- Card 4: Daftar Siswa Kelas -->
            <a href="{{ route('viewSiswa') }}" class="modern-action-card">
                <div class="action-icon-badge bg-icon-purple">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Daftar Siswa {{ $namaKelas }}</h3>
                    <p class="action-desc">Lihat data & profil lengkap anggota kelas</p>
                </div>
                <ion-icon name="chevron-forward-outline" class="action-arrow"></ion-icon>
            </a>
        </div>
    </div>
@endsection

