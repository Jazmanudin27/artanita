<!DOCTYPE html>
<html lang="id">
@php
    $member = DB::table('member')
        ->where('member.kode_member', Auth::user()->kode_member)
        ->first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Artanita System - Modern Admin & Mobile Portal">
    <meta name="author" content="Artanita">

    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <title>@yield('titlepage') - Artanita System</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- App CSS (AdminKit / Bootstrap 5) -->
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Portal Premium Design System -->
    <style>
        :root {
            --portal-sidebar-bg: #141f36;
            --portal-sidebar-hover: #1e2c4a;
            --portal-sidebar-active: #2251a3;
            --portal-accent: #00d2ff;
            --portal-accent-blue: #2563eb;
            --portal-bg: #eef2f6;
            --portal-card-bg: #ffffff;
            --portal-text-dark: #1e293b;
            --portal-text-muted: #64748b;
            --portal-border: #cbd5e1;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--portal-bg);
            color: var(--portal-text-dark);
            overflow-x: hidden;
        }

        /* Wrapper Layout */
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar Styling */
        #sidebar {
            width: 270px;
            min-width: 270px;
            max-width: 270px;
            background: var(--portal-sidebar-bg);
            color: #ffffff;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.08);
        }

        #sidebar.collapsed {
            margin-left: -270px;
        }

        .sidebar-brand-wrapper {
            padding: 1.5rem 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #2563eb, #00d2ff);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .sidebar-brand-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #ffffff;
            line-height: 1.2;
        }

        /* User Profile Card inside Sidebar */
        .sidebar-user-card {
            margin: 1rem 1rem 0.5rem;
            padding: 0.85rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-user-info {
            overflow: hidden;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.88rem;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            display: inline-block;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 8px;
            background: rgba(0, 210, 255, 0.15);
            color: var(--portal-accent);
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* Navigation List */
        .sidebar-content {
            padding: 0.5rem 0.75rem 1.5rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-header {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            padding: 1.25rem 0.85rem 0.5rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 3px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.7rem 0.9rem;
            color: #94a3b8;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 10px;
            text-decoration: none !important;
            transition: all 0.2s ease;
            gap: 12px;
        }

        .sidebar-link i, .sidebar-link svg {
            width: 18px;
            height: 18px;
            color: #94a3b8;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        /* Mobile Responsive Off-Canvas & Mobile Touch Improvements */
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                height: 100vh !important;
                z-index: 1055 !important;
                margin-left: -270px !important;
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                box-shadow: 8px 0 25px rgba(0, 0, 0, 0.25) !important;
            }

            #sidebar.show-mobile, #sidebar:not(.collapsed) {
                margin-left: 0 !important;
            }

            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(2px);
                -webkit-backdrop-filter: blur(2px);
                z-index: 1045;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .sidebar-backdrop.show {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar Navigation -->
        <nav id="sidebar" class="sidebar collapsed">
            <!-- Brand Logo -->
            <div class="sidebar-brand-wrapper">
                <div class="sidebar-brand-logo">P</div>
                <div>
                    <div class="sidebar-brand-text">PORTAL</div>
                    <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 500;">ARTANITA SYSTEM</div>
                </div>
            </div>

            <!-- User Profile Summary in Sidebar -->
            <div class="sidebar-user-card">
                <img src="{{ asset('upload/3.png') }}" class="sidebar-user-avatar" alt="Avatar" />
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name" title="{{ $member->nama_member ?? 'User' }}">{{ $member->nama_member ?? 'User' }}</div>
                    <span class="sidebar-user-role">
                        @auth('guru') GURU @else ADMIN @endauth
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="sidebar-content js-simplebar">
                <ul class="sidebar-nav">
                    @if ($member && $member->exp_date > Date('Y-m-d'))
                        <li class="sidebar-header">Main Menu</li>
                        
                        @auth('guru')
                            <li class="sidebar-item {{ request()->is('dashboardGuru') ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{ route('dashboardGuru') }}">
                                    <i data-feather="grid"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @else
                            <li class="sidebar-item {{ request()->is('dashboardAdmin') ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{ route('dashboardAdmin') }}">
                                    <i data-feather="grid"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endauth

                        <!-- Data Master Dropdown -->
                        @php $isDataMasterActive = request()->is('viewGuru*') || request()->is('viewSiswa*') || request()->is('viewKelas*') || request()->is('viewMapel*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#ui" data-target="#ui" data-toggle="collapse" class="sidebar-link {{ $isDataMasterActive ? '' : 'collapsed' }}" aria-expanded="{{ $isDataMasterActive ? 'true' : 'false' }}">
                                <i data-feather="database"></i>
                                <span>Data Master</span>
                            </a>
                            <ul id="ui" class="sidebar-dropdown list-unstyled collapse {{ $isDataMasterActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewGuru*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewGuru') }}">Data Guru</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewSiswa*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSiswa') }}">Data Siswa</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewKelas*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewKelas') }}">Data Kelas</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewMapel*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewMapel') }}">Mata Pelajaran</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Surat Dropdown -->
                        @php $isSuratActive = request()->is('viewSuratAbsen*') || request()->is('viewSuratTeguran*') || request()->is('viewSuratDispensasi*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#surat" data-target="#surat" data-toggle="collapse" class="sidebar-link {{ $isSuratActive ? '' : 'collapsed' }}" aria-expanded="{{ $isSuratActive ? 'true' : 'false' }}">
                                <i data-feather="mail"></i>
                                <span>Surat Menyurat</span>
                            </a>
                            <ul id="surat" class="sidebar-dropdown list-unstyled collapse {{ $isSuratActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSuratAbsen*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSuratAbsen') }}">Absen Guru</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewSuratTeguran*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSuratTeguran') }}">Surat Teguran</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewSuratDispensasi*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSuratDispensasi') }}">Dispensasi</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Absensi Dropdown -->
                        @php $isAbsensiActive = request()->is('viewAbsensiSiswa*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#absensi" data-target="#absensi" data-toggle="collapse" class="sidebar-link {{ $isAbsensiActive ? '' : 'collapsed' }}" aria-expanded="{{ $isAbsensiActive ? 'true' : 'false' }}">
                                <i data-feather="check-square"></i>
                                <span>Presensi & Absensi</span>
                            </a>
                            <ul id="absensi" class="sidebar-dropdown list-unstyled collapse {{ $isAbsensiActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewAbsensiSiswa*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewAbsensiSiswa') }}">Absensi Siswa</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-header">Laporan & Rekap</li>

                        <!-- Laporan Master Dropdown -->
                        @php $isLapMasterActive = request()->is('laporanSiswa*') || request()->is('laporanGuru*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#report" data-target="#report" data-toggle="collapse" class="sidebar-link {{ $isLapMasterActive ? '' : 'collapsed' }}" aria-expanded="{{ $isLapMasterActive ? 'true' : 'false' }}">
                                <i data-feather="file-text"></i>
                                <span>Laporan Master</span>
                            </a>
                            <ul id="report" class="sidebar-dropdown list-unstyled collapse {{ $isLapMasterActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('laporanSiswa*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSiswa') }}">Laporan Siswa</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanGuru*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanGuru') }}">Laporan Guru</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Laporan Absensi Dropdown -->
                        @php $isLapAbsensiActive = request()->is('laporanPresensi*') || request()->is('laporanAbsensiSiswa*') || request()->is('laporanAbsensiMapel*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#report2" data-target="#report2" data-toggle="collapse" class="sidebar-link {{ $isLapAbsensiActive ? '' : 'collapsed' }}" aria-expanded="{{ $isLapAbsensiActive ? 'true' : 'false' }}">
                                <i data-feather="clipboard"></i>
                                <span>Laporan Absensi</span>
                            </a>
                            <ul id="report2" class="sidebar-dropdown list-unstyled collapse {{ $isLapAbsensiActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('laporanPresensi*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanPresensi') }}">Presensi Guru</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanAbsensiSiswa*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanAbsensiSiswa') }}">Absensi Siswa</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanAbsensiMapel*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanAbsensiMapel') }}">Absensi Mapel</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Laporan Surat Dropdown -->
                        @php $isLapSuratActive = request()->is('laporanSuratAbsen*') || request()->is('laporanSuratTeguran*') || request()->is('laporanSuratDispensasi*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#report3" data-target="#report3" data-toggle="collapse" class="sidebar-link {{ $isLapSuratActive ? '' : 'collapsed' }}" aria-expanded="{{ $isLapSuratActive ? 'true' : 'false' }}">
                                <i data-feather="send"></i>
                                <span>Laporan Surat</span>
                            </a>
                            <ul id="report3" class="sidebar-dropdown list-unstyled collapse {{ $isLapSuratActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('laporanSuratAbsen*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSuratAbsen') }}">Surat Absen</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanSuratTeguran*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSuratTeguran') }}">Surat Teguran</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanSuratDispensasi*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSuratDispensasi') }}">Surat Dispensasi</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Jadwal Pelajaran -->
                        <li class="sidebar-item {{ request()->is('cetakLaporanJadwal*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('cetakLaporanJadwal') }}" target="_blank">
                                <i data-feather="calendar"></i>
                                <span>Jadwal Pelajaran</span>
                            </a>
                        </li>

                        <!-- Perpustakaan -->
                        @php $isPerpusActive = request()->is('viewBuku*') || request()->is('viewPeminjaman*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#perpustakaan" data-target="#perpustakaan" data-toggle="collapse" class="sidebar-link {{ $isPerpusActive ? '' : 'collapsed' }}" aria-expanded="{{ $isPerpusActive ? 'true' : 'false' }}">
                                <i data-feather="book-open"></i>
                                <span>Perpustakaan</span>
                            </a>
                            <ul id="perpustakaan" class="sidebar-dropdown list-unstyled collapse {{ $isPerpusActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewBuku*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewBuku') }}">Katalog Buku</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewPeminjaman*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewPeminjaman') }}">Peminjaman Buku</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Sarana Prasarana -->
                        <li class="sidebar-item {{ request()->is('laporanSapras*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('laporanSapras') }}">
                                <i data-feather="archive"></i>
                                <span>Sarana Prasarana</span>
                            </a>
                        </li>

                        <li class="sidebar-header">Sistem</li>

                        <!-- Settings Dropdown -->
                        @php $isSettingsActive = request()->is('viewSettings*') || request()->is('viewJadwal*'); @endphp
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#settings" data-target="#settings" data-toggle="collapse" class="sidebar-link {{ $isSettingsActive ? '' : 'collapsed' }}" aria-expanded="{{ $isSettingsActive ? 'true' : 'false' }}">
                                <i data-feather="settings"></i>
                                <span>Pengaturan</span>
                            </a>
                            <ul id="settings" class="sidebar-dropdown list-unstyled collapse {{ $isSettingsActive ? 'show' : '' }}" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSettings*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSettings') }}">Pengaturan Sistem</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewJadwal*') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewJadwal') }}">Setting Jadwal</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="sidebar-item">
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#settings" data-target="#settings" data-toggle="collapse" class="sidebar-link collapsed">
                                <i data-feather="settings"></i>
                                <span>Settings</span>
                            </a>
                            <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSettings') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSettings') }}">Setting</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Main Content Panel -->
        <div class="main">
            <!-- Header Navbar -->
            <header class="navbar-custom">
                <div class="d-flex align-items-center gap-3">
                    <button id="sidebar-toggle-btn" class="sidebar-toggle-btn" aria-label="Toggle Navigation">
                        <i data-feather="menu"></i>
                    </button>

                    <!-- Search Bar in Header -->
                    <div class="header-search d-none d-md-block">
                        <i data-feather="search" class="header-search-icon"></i>
                        <input type="text" placeholder="Cari data, menu..." aria-label="Search">
                        <span class="header-shortcut-badge">Ctrl+/</span>
                    </div>
                </div>

                <div class="header-right">
                    <!-- Realtime Clock Badge -->
                    <div class="clock-badge d-none d-sm-flex">
                        <i data-feather="clock" style="width: 14px; height: 14px;"></i>
                        <span id="clock">--:--:--</span>
                    </div>

                    <!-- Quick Notifications / Actions -->
                    <div class="header-action-icon d-none d-md-flex">
                        <i data-feather="bell" style="width: 18px; height: 18px;"></i>
                        <span class="header-action-badge">3</span>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <div class="user-dropdown-btn" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('upload/3.png') }}" class="user-dropdown-avatar" alt="Avatar" />
                            <span class="user-dropdown-name d-none d-sm-inline-block">{{ $member->nama_member ?? 'User' }}</span>
                            <i data-feather="chevron-down" style="width: 14px; height: 14px; color: #64748b;"></i>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 mt-2" style="border-radius: 12px; font-size: 0.88rem;">
                            <a class="dropdown-item py-2 px-3" href="#"><i data-feather="user" class="mr-2" style="width: 16px; height: 16px;"></i> Profile</a>
                            <a class="dropdown-item py-2 px-3" href="{{ route('viewSettings') }}"><i data-feather="settings" class="mr-2" style="width: 16px; height: 16px;"></i> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 px-3 text-danger" href="{{ route('signOut') }}"><i data-feather="log-out" class="mr-2" style="width: 16px; height: 16px;"></i> Log out</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body Content -->
            <main class="content">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            icon: 'success',
                            confirmButtonColor: '#2563eb'
                        });
                    </script>
                @endif
                @if (session('warning'))
                    <script>
                        Swal.fire({
                            title: 'Perhatian',
                            text: '{{ session('warning') }}',
                            icon: 'warning',
                            confirmButtonColor: '#2563eb'
                        });
                    </script>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted align-items-center">
                        <div class="col-6 text-left">
                            <p class="mb-0">
                                <strong>Artanita System</strong> &copy; {{ date('Y') }} - All rights reserved.
                            </p>
                        </div>
                        <div class="col-6 text-right" style="font-size: 0.8rem; color: #94a3b8;">
                            Powered by IT Tasikmalaya
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- AdminKit Core JS & Feather Icons -->
    <script src="{{ asset('adminkit/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Mobile Backdrop Element Creation
            if ($('.sidebar-backdrop').length === 0) {
                $('body').append('<div class="sidebar-backdrop"></div>');
            }

            // Sync Desktop vs Mobile initial state
            function initSidebarState() {
                if ($(window).width() <= 991.98) {
                    $('#sidebar').addClass('collapsed');
                } else {
                    $('#sidebar').removeClass('collapsed');
                }
            }
            initSidebarState();

            function syncMobileSidebarState() {
                if ($(window).width() <= 991.98) {
                    if (!$('#sidebar').hasClass('collapsed')) {
                        $('.sidebar-backdrop').addClass('show');
                        $('body').css('overflow', 'hidden');
                    } else {
                        $('.sidebar-backdrop').removeClass('show');
                        $('body').css('overflow', '');
                    }
                } else {
                    $('.sidebar-backdrop').removeClass('show');
                    $('body').css('overflow', '');
                }
            }

            // Keep Active Parent Dropdown Open
            $('.sidebar-dropdown .sidebar-item.active').each(function() {
                var $dropdown = $(this).closest('.sidebar-dropdown');
                $dropdown.addClass('show');
                $dropdown.prev('.sidebar-link').removeClass('collapsed').attr('aria-expanded', 'true');
            });

            // Sidebar Toggle Button Click
            $('#sidebar-toggle-btn').on('click touchstart', function(e) {
                e.preventDefault();
                $('#sidebar').toggleClass('collapsed');
                syncMobileSidebarState();
            });

            // Close Mobile Sidebar on Backdrop click
            $(document).on('click touchstart', '.sidebar-backdrop', function(e) {
                e.preventDefault();
                $('#sidebar').addClass('collapsed');
                syncMobileSidebarState();
            });

            // Close Mobile Sidebar when a navigation link is clicked (excluding dropdown toggles)
            $('.sidebar-nav a:not([data-toggle="collapse"]):not([data-bs-toggle="collapse"])').on('click', function() {
                if ($(window).width() <= 991.98) {
                    $('#sidebar').addClass('collapsed');
                    syncMobileSidebarState();
                }
            });

            // Manual fallback click handler for sidebar collapse dropdown toggles
            $('.sidebar-nav a[data-toggle="collapse"], .sidebar-nav a[data-bs-toggle="collapse"]').on('click touchstart', function(e) {
                e.preventDefault();
                var targetId = $(this).attr('data-bs-target') || $(this).attr('data-target');
                if (targetId) {
                    var $target = $(targetId);
                    if ($target.length) {
                        $target.toggleClass('show');
                        $(this).toggleClass('collapsed');
                        var isExpanded = $target.hasClass('show');
                        $(this).attr('aria-expanded', isExpanded ? 'true' : 'false');
                    }
                }
            });

            // Window Resize listener to update sidebar mobile overlay
            $(window).on('resize', function() {
                syncMobileSidebarState();
            });

            // Mask Money Init
            if ($.fn.maskMoney) {
                $('.uang').maskMoney({
                    thousands: ',',
                    precision: 0
                });
            }

            // SweetAlert Delete Confirmation
            $('.delete').on("click", function(e) {
                e.preventDefault();
                var href = $(this).attr('data-href');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });

            // DataTables Global Init
            if ($.fn.DataTable) {
                $('.datatables').DataTable({
                    responsive: true,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Cari data..."
                    }
                });
            }

            // Select2 Init
            if ($.fn.select2) {
                $('.select2').select2({
                    width: '100%'
                });
            }

            // Datepicker Init
            if ($.fn.datepicker) {
                $('.datepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                });
            }

            // Realtime Clock Updater
            function updateClock() {
                var now = new Date();
                var date = now.getDate();
                var month = now.getMonth();
                var year = now.getFullYear();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();

                hours = (hours < 10) ? "0" + hours : hours;
                minutes = (minutes < 10) ? "0" + minutes : minutes;
                seconds = (seconds < 10) ? "0" + seconds : seconds;

                var bulan = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                var timeStr = date + " " + bulan[month] + " " + year + " • " + hours + ":" + minutes + ":" + seconds;
                $('#clock').text(timeStr);
            }

            setInterval(updateClock, 1000);
            updateClock();
        });
    </script>
</body>
</html>
