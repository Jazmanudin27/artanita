@extends('frontend.template')
@section('titlepage', 'Form Edit Guru')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Data Guru</div>
        <div class="right">
            <a data-href="{{ route('deleteGuru', $guru->kode_guru) }}" class="headerButton" id="delete">
                <ion-icon name="trash-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('updateGuru') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Guru</label>
                                <input type="hidden" value="{{ $guru->kode_guru }}" name="kode_guru" class="form-control"
                                    placeholder="Kode Guru">
                                <input type="text" value="{{ $guru->nama_guru }}" name="nama_guru" class="form-control"
                                    placeholder="Nama Guru">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Kode Guru</label>
                                <input type="text" value="{{ $guru->no_urut }}" name="no_urut" class="form-control"
                                    placeholder="Kode Guru">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">NIP/NUPTK</label>
                                <input type="text" value="{{ $guru->nip_nuptk }}" name="nip_nuptk" class="form-control"
                                    placeholder="NIP/NUPTK" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Jenis Kelamin</label>
                                <select class="form-control select2" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option {{ $guru->jk == 'L' ? 'selected' : '' }} value="L">Laki-laki</option>
                                    <option {{ $guru->jk == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Alamat</label>
                                <input type="text" value="{{ $guru->alamat }}" name="alamat" class="form-control"
                                    placeholder="Alamat">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tempat Lahir</label>
                                <input type="text" value="{{ $guru->tempat_lahir }}" name="tempat_lahir"
                                    id="tempat_lahir" required class="form-control" placeholder="Tempat Lahir">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tgl Lahir</label>
                                <input type="date" value="{{ $guru->tgl_lahir }}" name="tgl_lahir" id="tgl_lahir"
                                    required class="form-control datepicker" placeholder="Tgl Lahir">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">No HP</label>
                                <input type="number" value="{{ $guru->no_hp }}" value="0" name="no_hp"
                                    class="form-control" placeholder="No HP">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Email</label>
                                <input type="email" value="{{ $guru->email }}" name="email" class="form-control"
                                    placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Username (untuk Login)</label>
                                <input type="text" value="{{ $guru->username ?? '' }}" name="username" class="form-control"
                                    placeholder="Username untuk login">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Password Baru (Opsional)</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Agama</label>
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
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Status Kepegawaian</label>
                                <input type="text" value="{{ $guru->status_kepegawaian }}" name="status_kepegawaian"
                                    class="form-control" placeholder="Status Kepegawaian" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Pendidikan Terakhir</label>
                                <input type="text" value="{{ $guru->pendidikan_terakhir }}"
                                    name="pendidikan_terakhir" class="form-control" placeholder="Pendidikan Terakhir"
                                    required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">TMT</label>
                                <input type="text" value="{{ $guru->tmt }}" name="tmt" class="form-control"
                                    placeholder="TMT" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option {{ $guru->status == 'Aktif' ? 'selected' : '' }} value="Aktif">Aktif
                                    </option>
                                    <option {{ $guru->status == 'Tidak Aktif' ? 'selected' : '' }} value="Tidak Aktif">
                                        Lulus
                                    </option>
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
