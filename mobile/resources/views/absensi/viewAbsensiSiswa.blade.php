@extends('frontend.template')
@section('titlepage', 'Data Absensi Siswa')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Absensi Siswa
        </div>
        <div class="right">
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <div class="form-group basic">
                        <label class="label">Tanggal</label>
                        <div class="input-group">
                            <input type="date" value="{{ Date('Y-m-d') }}" id="tanggal" class="form-control"
                                placeholder="Tanggal">
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Kelas</label>
                            <select class="form-control custom-select" id="kode_kelas">
                                @php
                                    if (Auth::guard('siswa')->check()) {
                                        $kode_kelas = Auth::guard('siswa')->user()->kode_kelas;
                                        $kelas = DB::select(
                                            "SELECT * FROM kelas WHERE kode_kelas = '$kode_kelas' ORDER BY nama_kelas ASC",
                                        );
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
        </div>
        <div class="section mt-2 mb-5">
            <div class="section-title">Data Siswa</div>
            <div class="card" id="showAbsensiSiswa">

            </div>
        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showAbsensiSiswa();

            function showAbsensiSiswa() {

                var tanggal = $('#tanggal').val();
                var kode_kelas = $('#kode_kelas').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showAbsensiSiswa') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        kode_kelas: kode_kelas,
                    },
                    success: function(data) {
                        $('#showAbsensiSiswa').html(data);
                    },
                });
            }

            $('#tanggal,#kode_kelas').change(function() {
                showAbsensiSiswa();
            });
        });
    </script>
@endsection
