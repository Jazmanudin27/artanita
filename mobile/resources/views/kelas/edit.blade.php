@extends('frontend.template')
@section('titlepage', 'Form Edit Kelas')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Edit Kelas</div>
        <div class="right">
            <a data-href="{{ route('deleteKelas', $kelas->kode_kelas) }}" class="headerButton" id="delete">
                <ion-icon name="trash-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('updateKelas') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Kelas</label>
                                <input type="hidden" name="kode_kelas" value="{{ $kelas->kode_kelas }}"
                                    class="form-control" placeholder="Kode Siswa" required>
                                <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}"
                                    class="form-control" placeholder="Nama Siswa" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Jurusan</label>
                                <input type="text" name="jurusan" value="{{ $kelas->jurusan }}" class="form-control"
                                    placeholder="Jurusan" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Wali Kelas</label>
                                <select class="form-control select2" name="kode_guru">
                                    @php
                                        $guru = DB::select('SELECT * FROM guru');
                                    @endphp
                                    <option value="">Pilih guru</option>
                                    @foreach ($guru as $k)
                                        <option value="{{ $k->kode_guru }}"
                                            {{ $kelas->kode_guru == $k->kode_guru ? 'selected' : '' }}>{{ $k->nama_guru }}
                                        </option>
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
