@extends('layouts.template')
@section('titlepage', 'Form Tambah Guru')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Tambah Guru</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateGuru') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Kode Guru</label>
                                <input type="text" name="no_urut" value="{{ $guru->no_urut }}" class="form-control"
                                    placeholder="Kode Guru" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Guru</label>
                                <input type="hidden" value="{{ $guru->kode_guru }}" name="kode_guru" class="form-control"
                                    placeholder="Kode Guru">
                                <input type="text" value="{{ $guru->nama_guru }}" name="nama_guru" class="form-control"
                                    placeholder="Nama Guru">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NUPTK</label>
                                <input type="text" value="{{ $guru->nip_nuptk }}" name="nip_nuptk" class="form-control"
                                    placeholder="NIP/NUPTK" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" value="{{ $guru->tempat_lahir }}" name="tempat_lahir"
                                    id="tempat_lahir" required class="form-control" placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" value="{{ $guru->tgl_lahir }}" name="tgl_lahir" id="tgl_lahir"
                                    required class="form-control datepicker" placeholder="Tempat Lahir">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" value="{{ $guru->alamat }}" name="alamat" class="form-control"
                                    placeholder="Alamat">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" value="{{ $guru->no_hp }}" value="0" name="no_hp"
                                    class="form-control" placeholder="No HP">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ $guru->email }}" name="email" class="form-control"
                                    placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control select2" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option {{ $guru->jk == 'L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                    <option {{ $guru->jk == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Kepegawaian</label>
                                <input type="text" value="{{ $guru->status_kepegawaian }}" name="status_kepagawaian"
                                    class="form-control" placeholder="Status Kepegawaian" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <input type="text" value="{{ $guru->pendidikan_terakhir }}" name="pendidikan_terakhir"
                                    class="form-control" placeholder="Pendidikan Terakhir" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TMT</label>
                                <input type="text" value="{{ $guru->tmt }}" name="tmt" class="form-control"
                                    placeholder="TMT" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Agama</label>
                                <select class="form-control select2" name="agama" id="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option {{ $guru->agama == 'Islam' ? 'selected' : '' }} value="Islam">Islam</option>
                                    <option {{ $guru->agama == 'Kristen' ? 'selected' : '' }} value="Kristen">Kristen
                                    </option>
                                    <option {{ $guru->agama == 'Budha' ? 'selected' : '' }} value="Budha">Budha</option>
                                    <option {{ $guru->agama == 'Hindu' ? 'selected' : '' }} value="Hindu">Hindu</option>
                                    <option {{ $guru->agama == 'Konghucu' ? 'selected' : '' }} value="Konghucu">Konghucu
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option {{ $guru->status == 'Aktif' ? 'selected' : '' }} value="Aktif">Aktif
                                    </option>
                                    <option {{ $guru->status == 'Non Aktif' ? 'selected' : '' }} value="Non Aktif">Non
                                        Aktif
                                    </option>
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
