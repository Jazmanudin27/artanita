@extends('frontend.template')
@section('titlepage', 'Form Edit Siswa')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Data Siswa</div>
        <div class="right">
            <a data-href="{{ route('deleteSiswa', $siswa->kode_siswa) }}" class="headerButton" id="delete">
                <ion-icon name="trash-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('updateSiswa') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Siswa</label>
                                <input type="hidden" value="{{ $siswa->kode_siswa }}" name="kode_siswa"
                                    class="form-control" placeholder="Kode Siswa">
                                <input type="text" value="{{ $siswa->nama_siswa }}" name="nama_siswa"
                                    class="form-control" placeholder="Nama Siswa">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">NISN</label>
                                <input type="text" value="{{ $siswa->nisn }}" name="nisn" class="form-control"
                                    placeholder="NISN" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Alamat</label>
                                <input type="text" value="{{ $siswa->alamat }}" name="alamat" class="form-control"
                                    placeholder="Alamat">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tempat Lahir</label>
                                <input type="text" value="{{ $siswa->tempat_lahir }}" name="tempat_lahir"
                                    id="tempat_lahir" required class="form-control" placeholder="Tempat Lahir">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tgl Lahir</label>
                                <input type="date" value="{{ $siswa->tgl_lahir }}" name="tgl_lahir" id="tgl_lahir"
                                    required class="form-control datepicker" placeholder="Tgl Lahir">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">No HP</label>
                                <input type="number" value="{{ $siswa->no_hp }}" value="0" name="no_hp"
                                    class="form-control" placeholder="No HP">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Email</label>
                                <input type="email" value="{{ $siswa->email }}" name="email" class="form-control"
                                    placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Jenis Kelamin</label>
                                <select class="form-control select2" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option {{ $siswa->jk == 'L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                    <option {{ $siswa->jk == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Agama</label>
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
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Kelas</label>
                                <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                    @php
                                        $kelas = DB::select('SELECT * FROM kelas ');
                                    @endphp
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $p)
                                        <option {{ $siswa->kode_kelas == $p->kode_kelas ? 'selected' : '' }}
                                            value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Status</label>
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

            $('#delete').on("click", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('data-href');
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });

        });
    </script>
@endsection
