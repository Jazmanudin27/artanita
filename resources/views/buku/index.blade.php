@extends('layouts.template')
@section('titlepage', 'Data Buku')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Buku</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahBuku') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control" autocomplete="off" id="judul"
                                    placeholder="Judul">
                            </div>
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control" autocomplete="off" id="pengarang"
                                    placeholder="Pengarang">
                            </div>
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control" autocomplete="off" id="penerbit"
                                    placeholder="Penerbit">
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="zoom:85%">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Terbit</th>
                                        <th>Stok</th>
                                        <th>Dipinjam</th>
                                        <th>Sisa Stok</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showBuku">

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

            showBuku();

            function showBuku() {
                var judul = $('#judul').val();
                var penerbit = $('#penerbit').val();
                var pengarang = $('#pengarang').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('showBuku') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        judul: judul,
                        penerbit: penerbit,
                        pengarang: pengarang,
                    },
                    success: function(data) {
                        $('#showBuku').html(data);
                    },
                });
            }

            $('#judul,#penerbit,#pengarang').on("input", function(e) {
                e.preventDefault();
                showBuku();
            });

        });
    </script>

@endsection
