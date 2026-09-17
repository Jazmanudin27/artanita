@extends('layouts.template')
@section('titlepage', 'Data Kelas')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Kelas</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahKelas') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="seacrh" class="form-control" autocomplete="off" id="nama_kelas"
                                    placeholder="Nama Kelas">
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="zoom:85%">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Guru</th>
                                        <th>Jurusan</th>
                                        <th>Wali Kelas</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showKelas">

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

            showKelas();

            function showKelas() {

                var nama_kelas = $('#nama_kelas').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showKelas') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_kelas: nama_kelas,
                    },
                    success: function(data) {
                        $('#showKelas').html(data);
                    },
                });
            }

            $('#nama_kelas').on("input", function(e) {
                e.preventDefault();
                showKelas();
            });

        });
    </script>

@endsection
