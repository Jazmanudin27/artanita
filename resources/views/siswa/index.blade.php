@extends('layouts.template')
@section('titlepage', 'Data Siswa')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Siswa</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahSiswa') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="seacrh" class="form-control" autocomplete="off" id="nama_siswa"
                                    placeholder="Nama Siswa">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                    @php
                                        $kode_member = Auth::user()->kode_member;
                                        $kelas = DB::select("SELECT * FROM kelas WHERE kode_member = '$kode_member' ");
                                    @endphp
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $p)
                                        <option value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control select2" name="jk" id="jk">
                                    <option value="">Semua JK</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control select2" name="status" id="status">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Keluar/Pindah">Keluar/Pindah</option>
                                    <option value="Lulus">Lulus</option>
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
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tgl Lahir</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Status</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showSiswa">

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

            showSiswa();

            function showSiswa() {

                var kode_kelas = $('#kode_kelas').val();
                var nama_siswa = $('#nama_siswa').val();
                var status = $('#status').val();
                var jk = $('#jk').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showSiswa') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_siswa: nama_siswa,
                        kode_kelas: kode_kelas,
                        status: status,
                        jk: jk,
                    },
                    success: function(data) {
                        $('#showSiswa').html(data);
                    },
                });
            }

            $('#kode_kelas,#jk,#status').on("change", function(e) {
                e.preventDefault();
                showSiswa();
            });

            $('#nama_siswa').on("input", function(e) {
                e.preventDefault();
                showSiswa();
            });

        });
    </script>

@endsection
