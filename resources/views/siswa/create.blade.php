@extends('layouts.template')
@section('titlepage', 'Form Tambah Siswa')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Siswa</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('storeSiswa') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="text" name="nama_siswa" class="form-control" placeholder="Nama Siswa"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control" placeholder="NISN" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" placeholder="NIS" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Alamat" >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"  class="form-control"
                                    placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" name="tgl_lahir" id="tgl_lahir" value="{{ date('Y-m-d') }}" required
                                    class="form-control datepicker" placeholder="Tanggal Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" value="0" name="no_hp" class="form-control" placeholder="No HP"
                                    >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control select2" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Agama</label>
                                <select class="form-control select2" name="agama" id="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                    @php
                                        $kode_member = Auth::user()->kode_member;
                                        $kelas = DB::select("SELECT * FROM kelas WHERE kode_member = '{$kode_member}'");
                                    @endphp
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}">{{ $k->nama_kelas }}</option>
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
