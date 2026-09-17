@extends('layouts.template')
@section('titlepage', 'Data Absensi Siswa')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Absensi Siswa</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                  
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control datepicker" value="{{ Date('Y-m-d') }}"
                                    autocomplete="off" id="tanggal" placeholder="Tanggal">
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
                                        <th>Tanggal</th>
                                        <th style="text-align: center">Status</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showAbsensiSiswa">

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

            showAbsensiSiswa();

            function showAbsensiSiswa() {
                var tanggal = $('#tanggal').val();
                var kode_kelas = $('#kode_kelas').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('showAbsensiSiswa') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        kode_kelas: kode_kelas,
                    },
                    success: function(data) {
                        $('#showAbsensiSiswa').html(data);
                    },
                });
            }

            $('#tanggal,#kode_kelas').on("input", function(e) {
                e.preventDefault();
                showAbsensiSiswa();
            });

        });
    </script>

@endsection
