@extends('layouts.template')
@section('titlepage', 'Data Absensi Mapel')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Absensi Mapel</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <a href="{{ route('tambahAbsensiMapel') }}" class="btn btn-primary">Tambah Data</a> --}}
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control datepicker" value="{{ Date('Y-m-d') }}"
                                    autocomplete="off" id="tanggal" placeholder="Tanggal">
                            </div>
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control" autocomplete="off" id="nama_siswa"
                                    placeholder="Nama Siswa">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control select2" id="kode_kelas">
                                    @php
                                        $data = DB::table('kelas')
                                            ->where('kode_member', Auth::user()->kode_member)
                                            ->get();
                                    @endphp
                                    <option value="">Semua Kelas</option>
                                    @foreach ($data as $d)
                                        <option value="{{ $d->kode_kelas }}">{{ $d->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control select2" id="kode_guru">
                                    @php
                                        $data = DB::table('guru')
                                            ->where('kode_member', Auth::user()->kode_member)
                                            ->get();
                                    @endphp
                                    <option value="">Semua Guru</option>
                                    @foreach ($data as $d)
                                        <option value="{{ $d->kode_guru }}">{{ $d->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control select2" id="kode_mapel">
                                    @php
                                        $data = DB::table('mapel')
                                            ->where('kode_member', Auth::user()->kode_member)
                                            ->get();
                                    @endphp
                                    <option value="">Semua Mapel</option>
                                    @foreach ($data as $d)
                                        <option value="{{ $d->kode_mapel }}">{{ $d->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="zoom:85%">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>JK</th>
                                        <th>Kelas</th>
                                        <th>Guru</th>
                                        <th>Mapel</th>
                                        <th>Tanggal</th>
                                        <th style="text-align: center">Status</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showAbsensiMapel">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            showAbsensiMapel();

            function showAbsensiMapel() {
                var tanggal = $('#tanggal').val();
                var nama_siswa = $('#nama_siswa').val();
                var kode_kelas = $('#kode_kelas').val();
                var kode_guru = $('#kode_guru').val();
                var kode_mapel = $('#kode_mapel').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('showAbsensiMapel') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        nama_siswa: nama_siswa,
                        kode_kelas: kode_kelas,
                        kode_guru: kode_guru,
                        kode_mapel: kode_mapel,
                    },
                    success: function(data) {
                        $('#showAbsensiMapel').html(data);
                    },
                });
            }

            $('#tanggal,#nama_siswa,#kode_kelas,#kode_mapel,#kode_guru').on("input", function(e) {
                e.preventDefault();
                showAbsensiMapel();
            });

        });
    </script>

@endsection
