@extends('layouts.template')
@section('titlepage', 'Form Pembayaran SPP')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Pembayaran SPP</h1>
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <input type="text" style="color:black" class="form-control" id="nobukti"
                                        placeholder="No Faktur">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <input type="text" style="color:black" class="form-control datepicker"
                                        value="{{ Date('Y-m-d') }}" id="tanggal" placeholder="Tanggal Bayar">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <input type="hidden" name="kode_siswa" id="kode_siswa" class="form-control"
                                        placeholder="Kode Siswa">
                                    <input type="text" name="nama_siswa" id="nama_siswa" class="form-control"
                                        placeholder="Nama Siswa">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <input type="hidden" name="kode_kelas" id="kode_kelas" class="form-control"
                                        placeholder="Kode Kelas">
                                    <input type="text" name="nama_kelas" id="nama_kelas" readonly class="form-control"
                                        placeholder="Kelas">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <input type="text" name="jurusan" id="jurusan" readonly class="form-control"
                                        placeholder="Jurusan">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <select class="form-control select2" name="kode_tahun_pelajaran"
                                        id="kode_tahun_pelajaran" required>
                                        @php
                                            $kode_member = Auth::user()->kode_member;
                                            $data = DB::select('SELECT * FROM tahun_pelajaran ORDER BY kode_tahun_pelajaran ASC');
                                            $member = DB::table('member')
                                                ->where('kode_member', $kode_member)
                                                ->first();
                                        @endphp
                                        <option value="">Tahun Pelajaran</option>
                                        @foreach ($data as $t)
                                            <option
                                                {{ $t->kode_tahun_pelajaran == $member->kode_tahun_pelajaran ? 'selected' : '' }}
                                                value="{{ $t->kode_tahun_pelajaran }}">{{ $t->tahun_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="bulan" id="bulan" class="form-control select2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                            value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="tahun" id="tahun" class="form-control select2">
                                    @php
                                        $startYear = '2023';
                                        $endYear = $startYear + 4;
                                    @endphp

                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option {{ Date('Y') == $year ? 'selected' : '' }} value="{{ $year }}">
                                            {{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <input type="text" name="jumlah" id="jumlah" style="text-align: right"
                                        class="form-control uang" placeholder="Jumlah">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="mb-3">
                                    <a href="#" class="btn btn-block btn-success" id="simpanTemp">Tambah</a>
                                </div>
                            </div>
                            <br>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <table class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th style="text-align:right">Jumlah</th>
                                                <th style="text-align:right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="showSppTemp">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <a href="#" class="btn btn-block btn-primary" id="simpanSppCetak">Simpan &
                                        Cetak</a>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <a href="#" class="btn btn-block btn-success" id="simpanSpp">Simpan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSiswa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body m-1">
                    <h4 style="text-align: center">DATA SISWA</h4>
                    <div class="table-reponsive" style="zoom:95%">
                        <table class="table table-striped datatables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>JK</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>{{ $s->jk }}</td>
                                        <td>{{ $s->nama_kelas }}</td>
                                        <td>{{ $s->jurusan }}</td>
                                        <td>
                                            <a href="#" data-kode="{{ $s->kode_siswa }}"
                                                data-nama="{{ $s->nama_siswa }}" data-jurusan="{{ $s->jurusan }}"
                                                data-kelas="{{ $s->kode_kelas }}" data-namakelas="{{ $s->nama_kelas }}"
                                                data-jk="{{ $s->jk }}"
                                                class="btn btn-sm btn-primary pilihSiswa"><i class="fa fa-check"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#nama_siswa').on("click", function(e) {
                e.preventDefault();
                $('#modalSiswa').modal("show");
                showSppTemp();
            });

            showSppTemp();

            function showSppTemp() {
                var kode_siswa = $('#kode_siswa').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('nobuktiSpp') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#nobukti').val(data);
                    },
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route('showSppTemp') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_siswa: kode_siswa,
                    },
                    success: function(data) {
                        $('#showSppTemp').html(data);
                    },
                });
            }

            $('.pilihSiswa').on("click", function(e) {
                e.preventDefault();
                var kode = $(this).attr('data-kode');
                var nama = $(this).attr('data-nama');
                var kelas = $(this).attr('data-kelas');
                var jurusan = $(this).attr('data-jurusan');
                var namakelas = $(this).attr('data-namakelas');
                var jk = $(this).attr('data-jk');
                $('#kode_siswa').val(kode);
                $('#nama_siswa').val(nama);
                $('#kode_kelas').val(kelas);
                $('#nama_kelas').val(namakelas);
                $('#jurusan').val(jurusan);
                $('#jk').val(jk);
                $('#modalSiswa').modal("hide");
                showSppTemp();
                $('#jumlah').focus();
            });

            $('#simpanTemp').on("click", function(e) {
                e.preventDefault();
                var kode_siswa = $('#kode_siswa').val();
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                var jumlah = $('#jumlah').val();
                var kode_kelas = $('#kode_kelas').val();
                var kode_tahun_pelajaran = $('#kode_tahun_pelajaran').val();
                if (kode_siswa == '') {
                    $('#modalSiswa').modal("show");
                } else if (jumlah == '') {
                    Swal.fire(
                        'Opps..',
                        'Isi jumlah terlebih dahulu',
                        'warning'
                    )
                    $('#jumlah').focus();
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('cekSppTemp') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            kode_siswa: kode_siswa,
                            bulan: bulan,
                            tahun: tahun,
                            kode_kelas: kode_kelas,
                        },
                        success: function(data) {
                            if (data > 0) {
                                Swal.fire(
                                    'Opps..',
                                    'SPP bulan ' + bulan + ' tahun ' + tahun +
                                    ' sudah ada dikeranjang',
                                    'warning'
                                )
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('storeSppTemp') }}',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        kode_siswa: kode_siswa,
                                        kode_kelas: kode_kelas,
                                        bulan: bulan,
                                        tahun: tahun,
                                        jumlah: jumlah,
                                    },
                                    success: function(data) {
                                        $('#jumlah').val("");
                                        showSppTemp();
                                    },
                                });
                            }
                        },
                    });
                }
            });

            $('#simpanSpp,#simpanSppCetak').on("click", function(e) {
                e.preventDefault();
                var simpanSppCetak = $('#simpanSppCetak').html();
                var simpanSpp = $('#simpanSpp').html();
                var nobukti = $('#nobukti').val();
                var kode_siswa = $('#kode_siswa').val();
                var tanggal = $('#tanggal').val();
                var kode_kelas = $('#kode_kelas').val();
                var kode_tahun_pelajaran = $('#kode_tahun_pelajaran').val();
                if (kode_siswa == '') {
                    $('#modalSiswa').modal("show");
                } else if (kode_tahun_pelajaran == '') {
                    Swal.fire(
                        'Opps..',
                        'Isi Tahun Pelajaran',
                        'warning'
                    )
                } else if (tanggal == '') {
                    Swal.fire(
                        'Opps..',
                        'Pilih tanggal terlebih dahulu',
                        'warning'
                    )
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('storeSpp') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            nobukti: nobukti,
                            kode_siswa: kode_siswa,
                            kode_kelas: kode_kelas,
                            kode_tahun_pelajaran: kode_tahun_pelajaran,
                            tanggal: tanggal,
                        },
                        success: function(data) {
                            if (simpanSpp == 'Simpan') {
                                window.location.href = '{{ route('tambahSpp') }}';
                            } else {
                                window.location.href = '{{ route('tambahSpp') }}';
                            }
                        },
                    });
                }
            });

        });
    </script>
@endsection
