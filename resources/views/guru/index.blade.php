@extends('layouts.template')
@section('titlepage', 'Data Guru')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Guru</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahGuru') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="seacrh" class="form-control" autocomplete="off" id="nama_guru"
                                    placeholder="Nama Guru">
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
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non Aktif">Non Aktif</option>
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
                                        <th>Nama Guru</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No HP</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showGuru">

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

            showGuru();

            function showGuru() {

                var kode_kelas = $('#kode_kelas').val();
                var nama_guru = $('#nama_guru').val();
                var status = $('#status').val();
                var jk = $('#jk').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showGuru') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_guru: nama_guru,
                        status: status,
                        jk: jk,
                    },
                    success: function(data) {
                        $('#showGuru').html(data);
                    },
                });
            }

            $('#jk,#status').on("change", function(e) {
                e.preventDefault();
                showGuru();
            });

            $('#nama_guru').on("input", function(e) {
                e.preventDefault();
                showGuru();
            });

        });
    </script>

@endsection
