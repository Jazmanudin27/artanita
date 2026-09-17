@extends('layouts.template')
@section('titlepage', 'Form Tambah Mapel')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Mapel</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateMapel') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Mapel</label>
                                <input type="hidden" value="{{ $mapel->kode_mapel }}" name="kode_mapel"
                                    class="form-control" placeholder="Kode Mapel">
                                <input type="text" value="{{ $mapel->nama_mapel }}" name="nama_mapel"
                                    class="form-control" placeholder="Nama Mapel" required>
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
