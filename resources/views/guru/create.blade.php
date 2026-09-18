@extends('layouts.template')
@section('titlepage', 'Form Tambah Guru')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Guru</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('storeGuru') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Kode Guru</label>
                                <input type="text" name="no_urut" class="form-control" placeholder="Kode Guru" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Guru</label>
                                <input type="text" name="nama_guru" class="form-control" placeholder="Nama Guru"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NUPTK</label>
                                <input type="text" name="nip_nuptk" class="form-control" placeholder="NIP/NUPTK"
                                    required>
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
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" required class="form-control"
                                    placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" name="tgl_lahir" id="tgl_lahir" required
                                    class="form-control datepicker" placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" value="0" name="no_hp" class="form-control" placeholder="No HP"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username (untuk Login)</label>
                                <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password untuk login" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Kepegawaian</label>
                                <input type="text" name="status_kepegawaian" class="form-control"
                                    placeholder="Status Kepegawaian" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan_terakhir" class="form-control"
                                    placeholder="Pendidikan Terakhir" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TMT</label>
                                <input type="text" name="tmt" class="form-control" placeholder="TMT" required>
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
