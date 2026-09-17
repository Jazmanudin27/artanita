@extends('layouts.template')
@section('titlepage', 'Form Tambah Kelas')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Kelas</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateKelas') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Kelas</label>
                                <input type="hidden" value="{{ $kelas->kode_kelas }}" name="kode_kelas"
                                    class="form-control" placeholder="Kode Kelas">
                                <input type="text" value="{{ $kelas->nama_kelas }}" name="nama_kelas"
                                    class="form-control" placeholder="Nama Kelas" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" value="{{ $kelas->jurusan }}" name="jurusan" class="form-control"
                                    placeholder="Jurusan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <select class="form-control select2" name="kode_guru" id="kode_guru">
                                    @php
                                        $kode_member = Auth::user()->kode_member;
                                        $guru = DB::select("SELECT * FROM guru WHERE kode_member = '$kode_member' ");
                                    @endphp
                                    <option value="">Pilih Wali Kelas</option>
                                    @foreach ($guru as $k)
                                        <option {{ $kelas->kode_guru == $k->kode_guru ? 'selected' : '' }}
                                            value="{{ $k->kode_guru }}">
                                            {{ $k->nama_guru }}</option>
                                    @endforeach
                                </select>
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
