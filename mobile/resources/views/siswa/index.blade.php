@extends('frontend.template')
@section('titlepage', 'Data Siswa')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Siswa</div>
        <div class="right">
            <a href="{{ route('tambahSiswa') }}" class="headerButton">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama Siswa</label>
                                    <input type="seacrh" class="form-control" autocomplete="off" id="nama_siswa"
                                        placeholder="Nama Siswa">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Kelas</label>
                                    <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                        @php
                                            if (Auth::guard('kelas')->check()) {
                                                $kode_kelas = Auth::guard('kelas')->user()->kode_kelas;
                                                $kelas = DB::select("SELECT * FROM kelas WHERE kode_kelas = '$kode_kelas' ORDER BY nama_kelas ASC");
                                            } else if (Auth::guard('siswa')->check()) {
                                                $kode_kelas = Auth::guard('siswa')->user()->kode_kelas;
                                                $kelas = DB::select("SELECT * FROM kelas WHERE kode_kelas = '$kode_kelas' ORDER BY nama_kelas ASC");
                                            } else {
                                                $kelas = DB::select('SELECT * FROM kelas ORDER BY nama_kelas ASC');
                                            }
                                        @endphp
                                        @foreach ($kelas as $p)
                                            <option value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jenis Kelamin</label>
                                    <select class="form-control select2" name="jk" id="jk">
                                        <option value="">Semua JK</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Status</label>
                                    <select class="form-control select2" name="status" id="status">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Keluar/Pindah">Keluar/Pindah</option>
                                        <option value="Lulus">Lulus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-5" id="showSiswa">

        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showSiswa();

            function showSiswa() {

                var kode_kelas = $('#kode_kelas').val();
                var nama_siswa = $('#nama_siswa').val();
                var status = $('#status').val();
                var jk = $('#jk').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showSiswa') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_siswa: nama_siswa,
                        kode_kelas: kode_kelas,
                        status: status,
                        jk: jk,
                    },
                    success: function(data) {
                        $('#showSiswa').html(data);
                    },
                });
            }

            $('#kode_kelas,#jk,#status').on("change", function(e) {
                e.preventDefault();
                showSiswa();
            });

            $('#nama_siswa').on("input", function(e) {
                e.preventDefault();
                showSiswa();
            });

        });
    </script>

@endsection
