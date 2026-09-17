@extends('layouts.template')
@section('titlepage', 'Form Tambah Buku')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Buku</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('storeBuku') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengarang</label>
                                <input type="text" name="pengarang" class="form-control" placeholder="Pengarang"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" placeholder="Penerbit" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="text" name="tahun_terbit" class="form-control" placeholder="Tahun Terbit"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Stok</label>
                                <input type="text" name="jumlah_stok" class="form-control" placeholder="Jumlah Stok"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
