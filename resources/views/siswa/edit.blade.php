@extends('layouts.template')
@section('titlepage', 'Form Tambah Siswa')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Siswa</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateSiswa') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="hidden" value="{{ $siswa->kode_siswa }}" name="kode_siswa"
                                    class="form-control" placeholder="Kode Siswa">
                                <input type="text" value="{{ $siswa->nama_siswa }}" name="nama_siswa"
                                    class="form-control" placeholder="Nama Siswa">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" value="{{ $siswa->nisn }}" name="nisn" class="form-control"
                                    placeholder="NISN" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" value="{{ $siswa->nis }}" name="nis" class="form-control"
                                    placeholder="NIS" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" value="{{ $siswa->tempat_lahir }}" name="tempat_lahir"
                                    id="tempat_lahir" required class="form-control" placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" value="{{ $siswa->tgl_lahir }}" name="tgl_lahir" id="tgl_lahir"
                                    required class="form-control datepicker" placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" value="{{ $siswa->alamat }}" name="alamat" class="form-control"
                                    placeholder="Alamat">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" value="{{ $siswa->no_hp }}" value="0" name="no_hp"
                                    class="form-control" placeholder="No HP">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ $siswa->email }}" name="email" class="form-control"
                                    placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control select2" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option {{ $siswa->jk == 'L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                    <option {{ $siswa->jk == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Agama</label>
                                <select class="form-control select2" name="agama" id="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option {{ $siswa->agama == 'Islam' ? 'selected' : '' }} value="Islam">Islam</option>
                                    <option {{ $siswa->agama == 'Kristen' ? 'selected' : '' }} value="Kristen">Kristen
                                    </option>
                                    <option {{ $siswa->agama == 'Budha' ? 'selected' : '' }} value="Budha">Budha</option>
                                    <option {{ $siswa->agama == 'Hindu' ? 'selected' : '' }} value="Hindu">Hindu</option>
                                    <option {{ $siswa->agama == 'Konghucu' ? 'selected' : '' }} value="Konghucu">Konghucu
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                    @php
                                        $kode_member = Auth::user()->kode_member;
                                        $kelas = DB::select("SELECT * FROM kelas WHERE kode_member = '$kode_member' ");
                                    @endphp
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $p)
                                        <option {{ $siswa->kode_kelas == $p->kode_kelas ? 'selected' : '' }}
                                            value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option {{ $siswa->status == 'Aktif' ? 'selected' : '' }} value="Aktif">Aktif
                                    </option>
                                    <option {{ $siswa->status == 'Lulus' ? 'selected' : '' }} value="Lulus">Lulus
                                    </option>
                                    <option {{ $siswa->status == 'Keluar/Pindah' ? 'selected' : '' }}
                                        value="Keluar/Pindah">
                                        Keluar/Pindah</option>
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
