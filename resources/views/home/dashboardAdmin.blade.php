@extends('layouts.template')
@section('titlepage', 'Dashboard')
@section('content')
    @php
        $kode_member = Auth::user()->kode_member;
        $siswaTidakAktif = DB::table('siswa')
            ->where('status', 'Tidak Aktif')
            ->where('siswa.kode_member', $kode_member)
            ->count();
        $siswaAKtif = DB::table('siswa')
            ->where('status', 'Aktif')
            ->where('siswa.kode_member', $kode_member)
            ->count();
        $siswaLakiLaki = DB::table('siswa')
            ->where('status', 'Aktif')
            ->where('jk', 'L')
            ->where('siswa.kode_member', $kode_member)
            ->count();
        $siswaPerempuan = DB::table('siswa')
            ->where('status', 'Aktif')
            ->where('jk', 'P')
            ->where('siswa.kode_member', $kode_member)
            ->count();
    @endphp
    <div class="container-fluid p-0">
        <div class="mb-1">
            <h1 class="d-inline align-middle">Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-xl-12 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card" style="background-color: skyblue">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 btn btn-primary" style="color:black">Aktif</h5>
                                    <h2 class="mt-1 mb-3">{{ $siswaAKtif }} Siswa/i</h2>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card" style="background-color:orange">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 btn btn-danger" style="color:black">Tidak Aktif</h5>
                                    <h2 class="mt-1 mb-3">{{ $siswaTidakAktif }} Siswa/i</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card" style="background-color: green">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 btn btn-info" style="color:black">Laki-laki</h5>
                                    <h2 class="mt-1 mb-3">{{ $siswaLakiLaki }} Siswa</h2>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card" style="background-color: rgb(158, 0, 26)">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 btn btn-success" style="color:black">Perempuan</h5>
                                    <h2 class="mt-1 mb-3">{{ $siswaPerempuan }} Siswi</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header" style="padding: 0.6rem 0.5rem;">
                            <h4 style="text-align: center">JADWAL PELAJARAN</h4>
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <select class="form-control select2" name="hari" id="hari">
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-reponsive" id="loadJadwal">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h4 style="text-align: center">REKAP ABSENSI SISWA/I, MAPEL, & SURAT TEGURAN</h4>
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <select id="bulan" class="form-control select2">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option
                                                    {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                                    value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <select id="tahun" class="form-control select2">
                                            @php
                                                $startYear = '2023';
                                                $endYear = $startYear + 4;
                                            @endphp

                                            @for ($year = $startYear; $year <= $endYear; $year++)
                                                <option {{ Date('Y') == $year ? 'selected' : '' }}
                                                    value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <select class="form-control select2" name="kode_mapel" id="kode_mapel">
                                            @php
                                                $kode_member = Auth::user()->kode_member;
                                                $mapel = DB::select("SELECT * FROM mapel WHERE kode_member = '$kode_member' ORDER BY nama_mapel ASC");
                                            @endphp
                                            <option value="">Pilih mapel</option>
                                            @foreach ($mapel as $p)
                                                <option value="{{ $p->kode_mapel }}">{{ $p->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr style="color:black">
                                        <th colspan="3" style="text-align: center;background:green">Data Kelas</th>
                                        <th colspan="3" style="text-align: center;background:skyblue">Jumlah Siswa
                                        </th>
                                        <th colspan="3" style="text-align: center;background:green">Jumlah Absen</th>
                                        <th colspan="2" style="text-align: center;background:skyblue">Absensi</th>
                                        <th rowspan="2" style="text-align: center;background:orange">Teguran</th>
                                    </tr>
                                    <tr style="color:black">
                                        <th style="text-align: center;background:green">No</th>
                                        <th style="text-align: center;background:green">Kelas</th>
                                        <th style="text-align: center;background:green">Jurusan</th>
                                        <th style="text-align: center;background:skyblue">Laki-Laki</th>
                                        <th style="text-align: center;background:skyblue">Perempuan</th>
                                        <th style="text-align: center;background:skyblue">Total Siswa</th>
                                        <th style="text-align: center;background:green">Izin</th>
                                        <th style="text-align: center;background:green">Sakit</th>
                                        <th style="text-align: center;background:green">Alfa</th>
                                        <th style="text-align: center;background:skyblue">Siswa</th>
                                        <th style="text-align: center;background:skyblue">Mapel</th>
                                    </tr>
                                </thead>
                                <tbody id="loadAbsensiSiswaPerKelas">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal  fade" id="modalShowSiswaPerSiswa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body m-1">
                    <h4 style="text-align: center">DETAIL ABSENSI SISWA</h4>
                    <div class="table-reponsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="color:black">
                                    <th colspan="4" style="text-align: center;background:green">Data Siswa</th>
                                    <th colspan="3" style="text-align: center;background:orange">Jumlah Absen</th>
                                    <th rowspan="2" style="text-align: center;background:orange">Teguran</th>
                                </tr>
                                <tr style="color:black">
                                    <th style="text-align: center;background:green">No</th>
                                    <th style="text-align: center;background:green">Nama Siswa</th>
                                    <th style="text-align: center;background:green">NIS</th>
                                    <th style="text-align: center;background:green">JK</th>
                                    <th style="text-align: center;background:green">Izin</th>
                                    <th style="text-align: center;background:green">Sakit</th>
                                    <th style="text-align: center;background:green">Alfa</th>
                                </tr>
                            </thead>
                            <tbody id="loadAbsensiSiswaPerSiswa">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAbsensiMapel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body m-1">
                    <h4 style="text-align: center">DETAIL ABSENSI MAPEL</h4>
                    <div class="table-reponsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="color:black">
                                    <th colspan="4" style="text-align: center;background:green">Data Siswa</th>
                                    <th colspan="3" style="text-align: center;background:orange">Jumlah Absen</th>
                                </tr>
                                <tr style="color:black">
                                    <th style="text-align: center;background:green">No</th>
                                    <th style="text-align: center;background:green">Nama Siswa</th>
                                    <th style="text-align: center;background:green">NIS</th>
                                    <th style="text-align: center;background:green">JK</th>
                                    <th style="text-align: center;background:green">Izin</th>
                                    <th style="text-align: center;background:green">Sakit</th>
                                    <th style="text-align: center;background:green">Alfa</th>
                                </tr>
                            </thead>
                            <tbody id="loadAbsensiMapel">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal  fade" id="modalTeguran" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body m-1">
                    <h4 style="text-align: center">DETAIL SURAT TEGURAN SISWA</h4>
                    <div class="table-reponsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr style="color:black">
                                    <th colspan="4" style="text-align: center;background:green">Data Siswa</th>
                                    <th rowspan="2" style="text-align: center;background:orange">Tanggal</th>
                                    <th rowspan="2" style="text-align: left;background:orange">Deskripsi</th>
                                </tr>
                                <tr style="color:black">
                                    <th style="text-align: center;background:green">No</th>
                                    <th style="text-align: center;background:green">Nama Siswa</th>
                                    <th style="text-align: center;background:green">NIS</th>
                                    <th style="text-align: center;background:green">JK</th>
                                </tr>
                            </thead>
                            <tbody id="loadTeguran">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            function enableResponsiveTable() {
                $('#responsive-table').DataTable({
                    responsive: true
                });
            }
            enableResponsiveTable();

            loadAbsensiSiswaPerKelas();

            function loadAbsensiSiswaPerKelas() {

                var tahun = $('#tahun').val();
                var bulan = $('#bulan').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('loadAbsensiSiswaPerKelas') }}',
                    data: {
                        tahun: tahun,
                        bulan: bulan,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#loadAbsensiSiswaPerKelas').html(data);
                    },
                });
            }

            var today = new Date().toLocaleDateString('id-ID', {
                weekday: 'long'
            });
            $("#hari option[value='" + today + "']").prop("selected", true);

            loadJadwal();

            function loadJadwal() {

                var hari = $('#hari').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('loadJadwal') }}',
                    data: {
                        hari: hari,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#loadJadwal').html(data);
                    },
                });
            }

            $('#hari').on("change", function(e) {
                e.preventDefault();
                loadJadwal();
            });

            $('#bulan,#tahun').on("change", function(e) {
                e.preventDefault();
                loadAbsensiSiswaPerKelas();
            });


        });
    </script>
@endsection
