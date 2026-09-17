@extends('frontend.template')
@section('titlepage', 'Form Tambah Siswa')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Tambah Data Siswa</div>
        <div class="right">

        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('storeSiswa') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Siswa</label>
                                <input type="text" name="nama_siswa" class="form-control" placeholder="Nama Siswa"
                                    required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">NISN</label>
                                <input type="text" name="nisn" class="form-control" placeholder="NISN" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir"
                                    required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tgl Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" placeholder="Tgl Lahir"
                                    required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">No HP</label>
                                <input type="number" value="0" name="no_hp" class="form-control" placeholder="No HP"
                                    required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Jenis Kelamin</label>
                                <select class="form-control select2" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Agama</label>
                                <select class="form-control select2" name="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Kelas</label>
                                <select class="form-control select2" name="kode_kelas">
                                    @php
                                        $kelas = DB::select('SELECT * FROM kelas');
                                    @endphp
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->kode_kelas }}">{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
