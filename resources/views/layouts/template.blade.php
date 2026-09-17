<!DOCTYPE html>
<html lang="en">
@php
    $member = DB::table('member')
        ->where('member.kode_member', Auth::user()->kode_member)
        ->first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <title>@yield('titlepage')</title>

    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .table-reponsive {
            width: 100%;
            overflow-x: auto;
        }

        .select2-container {}
    </style>
</head>
@php
    $member = DB::table('member')
        ->where('member.kode_member', Auth::user()->kode_member)
        ->first();
@endphp

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar" style="zoom:90%">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="#">
                    <span class="align-middle">{{ $member->nama_member }}</span>
                </a>

                <ul class="sidebar-nav">
                    @if ($member->exp_date > Date('Y-m-d'))
                        <li class="sidebar-header">
                            Menu
                        </li>
                        @auth('guru')
                            <li class="sidebar-item {{ request()->is('dashboardGuru') ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{ route('dashboardGuru') }}">
                                    <i class="align-middle" data-feather="sliders"></i> <span
                                        class="align-middle">Dashboard</span>
                                </a>
                            </li>
                        @else
                            <li class="sidebar-item {{ request()->is('dashboardAdmin') ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{ route('dashboardAdmin') }}">
                                    <i class="align-middle" data-feather="sliders"></i> <span
                                        class="align-middle">Dashboard</span>
                                </a>
                            </li>
                        @endauth


                        <li class="sidebar-item">
                            <a data-target="#ui" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Data
                                    Master</span>
                            </a>
                            <ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewGuru') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewGuru') }}">Guru</a></li>
                                <li class="sidebar-item {{ request()->is('viewSiswa') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewSiswa') }}">Siswa</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewKelas') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewKelas') }}">Kelas</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewMapel') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewMapel') }}">Mapel</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a data-target="#surat" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="mail"></i> <span class="align-middle">Surat</span>
                            </a>
                            <ul id="surat" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSuratAbsen') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewSuratAbsen') }}">Absen Guru</a></li>
                                <li class="sidebar-item {{ request()->is('viewSuratTeguran') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewSuratTeguran') }}">Teguran</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewSuratDispensasi') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewSuratDispensasi') }}">Dispensasi</a>
                                </li>
                                {{-- <li class="sidebar-item {{ request()->is('viewSuratUndangan') ? 'active' : '' }}"><a
                                    class="sidebar-link" href="{{ route('viewSuratUndangan') }}">Surat Undangan</a>
                            </li> --}}
                            </ul>
                        </li>


                        <li class="sidebar-item">
                            <a data-target="#absensi" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="mail"></i> <span
                                    class="align-middle">Absensi</span>
                            </a>
                            <ul id="absensi" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewAbsensiSiswa') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewAbsensiSiswa') }}">Absensi Siswa</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a data-target="#report" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="book"></i> <span class="align-middle">Laporan
                                    Data Master</span>
                            </a>
                            <ul id="report" class="sidebar-dropdown list-unstyled collapse "
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('laporanSiswa') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSiswa') }}">Lap. Siswa</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanGuru') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanGuru') }}">Lap. Guru</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a data-target="#report2" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="book"></i> <span
                                    class="align-middle">Laporan Absnesi</span>
                            </a>
                            <ul id="report2" class="sidebar-dropdown list-unstyled collapse "
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('laporanPresensi') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanPresensi') }}">Lap. Presensi
                                        Guru</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanAbsensiSiswa') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanAbsensiSiswa') }}">Lap. Absensi
                                        Siswa</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanAbsensiMapel') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanAbsensiMapel') }}">Lap. Absensi
                                        Mapel</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a data-target="#report3" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="book"></i> <span
                                    class="align-middle">Laporan Surat</span>
                            </a>
                            <ul id="report3" class="sidebar-dropdown list-unstyled collapse "
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('laporanSuratAbsen') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSuratAbsen') }}">Lap. Surat
                                        Absen</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('laporanSuratTeguran') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSuratTeguran') }}">Lap. Surat
                                        Teguran</a>
                                </li>
                                <li
                                    class="sidebar-item {{ request()->is('laporanSuratDispensasi') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('laporanSuratDispensasi') }}">Lap. Surat
                                        Dispensasi</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ request()->is('cetakLaporanJadwal') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('cetakLaporanJadwal') }}"  target="_blank">
                                <i class="align-middle" data-feather="sliders"></i> <span
                                    class="align-middle">Jadwal Pelajaran</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a data-target="#perpustakaan" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="align-justify"></i> <span
                                    class="align-middle">Perpustakaan</span>
                            </a>
                            <ul id="perpustakaan" class="sidebar-dropdown list-unstyled collapse"
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewBuku') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewBuku') }}">Buku</a>
                                </li>
                                <li class="sidebar-item {{ request()->is('viewPeminjaman') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewPeminjaman') }}">Peminjaman</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item {{ request()->is('laporanSapras') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('laporanSapras') }}">
                                <i class="align-middle" data-feather="home"></i> <span
                                    class="align-middle">Sarana Prasarana</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a data-target="#spp" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="dollar-sign"></i> <span
                                    class="align-middle">Pembayaran</span>
                            </a>
                            <ul id="spp" class="sidebar-dropdown list-unstyled collapse"
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSpp') ? 'active' : '' }}"><a
                                        class="sidebar-link" href="{{ route('viewSpp') }}">SPP</a>
                                </li>
                            </ul>
                        </li> --}}

                        <li class="sidebar-item">
                            <a data-target="#settings" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="settings"></i> <span
                                    class="align-middle">Settings</span>
                            </a>
                            <ul id="settings" class="sidebar-dropdown list-unstyled collapse"
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSettings') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSettings') }}">Setting</a>
                                </li>
                            </ul>
                            <ul id="settings" class="sidebar-dropdown list-unstyled collapse"
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewJadwal') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewJadwal') }}">Jadwal Pelajaran</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="sidebar-item">
                            <a data-target="#settings" data-toggle="collapse" class="sidebar-link collapsed">
                                <i class="align-middle" data-feather="settings"></i> <span
                                    class="align-middle">Settings</span>
                            </a>
                            <ul id="settings" class="sidebar-dropdown list-unstyled collapse "
                                data-parent="#sidebar">
                                <li class="sidebar-item {{ request()->is('viewSettings') ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route('viewSettings') }}">Setting</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>
                <form class="d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                        <h4 id="clock"></h4>
                    </div>
                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown"
                                data-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">4</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0"
                                aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    4 New Notifications
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-danger" data-feather="alert-circle"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Update completed</div>
                                                <div class="text-muted small mt-1">Restart server 12 to complete
                                                    the
                                                    update.</div>
                                                <div class="text-muted small mt-1">30m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-warning" data-feather="bell"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Lorem ipsum</div>
                                                <div class="text-muted small mt-1">Aliquam ex eros, imperdiet
                                                    vulputate
                                                    hendrerit et.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-primary" data-feather="home"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Login from 192.186.1.8</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-success" data-feather="user-plus"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">New connection</div>
                                                <div class="text-muted small mt-1">Christina accepted your request.
                                                </div>
                                                <div class="text-muted small mt-1">14h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown"
                                data-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0"
                                aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('adminkit/img/avatars/avatar-5.jpg') }}"
                                                    class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">Vanessa Tucker</div>
                                                <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis
                                                    arcu tortor.</div>
                                                <div class="text-muted small mt-1">15m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('adminkit/img/avatars/avatar-2.jpg') }}"
                                                    class="avatar img-fluid rounded-circle" alt="William Harris">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">William Harris</div>
                                                <div class="text-muted small mt-1">Curabitur ligula sapien euismod
                                                    vitae.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('adminkit/img/avatars/avatar-4.jpg') }}"
                                                    class="avatar img-fluid rounded-circle" alt="Christina Mason">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">Christina Mason</div>
                                                <div class="text-muted small mt-1">Pellentesque auctor neque nec
                                                    urna.
                                                </div>
                                                <div class="text-muted small mt-1">4h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="{{ asset('adminkit/img/avatars/avatar-3.jpg') }}"
                                                    class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">Sharon Lessman</div>
                                                <div class="text-muted small mt-1">Aenean tellus metus, bibendum
                                                    sed,
                                                    posuere ac, mattis non.</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-toggle="dropdown">
                                <img src="{{ asset('upload/3.png') }}" class="avatar img-fluid rounded mr-1"
                                    alt="Charles Hall" /> <span class="text-dark">{{ $member->nama_member }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="pages-profile.html"><i class="align-middle mr-1"
                                        data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle mr-1"
                                        data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="pages-settings.html"><i class="align-middle mr-1"
                                        data-feather="settings"></i> Settings & Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle mr-1"
                                        data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('signOut') }}">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                @if (session('success'))
                    <script>
                        Swal.fire(
                            'Success',
                            '{{ session('success') }}',
                            'success'
                        )
                    </script>
                @endif
                @if (session('warning'))
                    <script>
                        Swal.fire(
                            'Opps,',
                            '{{ session('warning') }}',
                            'warning'
                        )
                    </script>
                @endif
                @yield('content')

            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-left">
                            <p class="mb-0">
                                <a href="#" class="text-muted"><strong>IT Tasikmalaya</strong></a> &copy;
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('adminkit/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {

            function kapitalDepan($kata) {
                if (!empty($kata)) {
                    $kata[0] = strtoupper($kata[0]);
                }
                return $kata;
            }

            $('.uang').maskMoney({
                thousands: ',',
                precision: 0
            });

            $('.delete').on("click", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('data-href');
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });

            $('.datatables').DataTable({
                responsive: true,
                lengthChange: false,
                ordering: false,
                info: false
            });

            $('.select2').select2();

            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
            });

            function enableHorizontalScroll() {
                $('.table-reponsive').each(function() {
                    var containerWidth = $(this).width();
                    var tableWidth = $('table', this).outerWidth();
                    if (tableWidth > containerWidth) {
                        $(this).addClass('scrollable');
                    } else {
                        $(this).removeClass('scrollable');
                    }
                });
            }

            $(window).on('resize', enableHorizontalScroll);
            enableHorizontalScroll();

            function updateClock() {
                var now = new Date();
                var date = now.getDate();
                var month = now.getMonth() + 1;
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
                var time = date + " " + bulan[month - 1] + " " + year + " " + hours + ":" + minutes + ":" + seconds;

                $('#clock').html(time);
            }
            setInterval(updateClock, 1000);
            updateClock();

        });
    </script>
</body>

</html>
