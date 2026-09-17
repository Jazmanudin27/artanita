@extends('layouts.template')
@section('titlepage', 'Data Mapel')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Mapel</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahMapel') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="seacrh" class="form-control" autocomplete="off" id="nama_mapel"
                                    placeholder="Nama Mapel">
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="zoom:85%">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mapel</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showMapel">

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

            showMapel();

            function showMapel() {

                var nama_mapel = $('#nama_mapel').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showMapel') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_mapel: nama_mapel,
                    },
                    success: function(data) {
                        $('#showMapel').html(data);
                    },
                });
            }

            $('#nama_mapel').on("input", function(e) {
                e.preventDefault();
                showMapel();
            });

        });
    </script>

@endsection
