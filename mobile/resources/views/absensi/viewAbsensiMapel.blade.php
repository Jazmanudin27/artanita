@extends('frontend.template')
@section('titlepage', 'Data Absensi Mapel')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Absensi Mapel
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
                                    $kelas = DB::select('SELECT * FROM kelas  ORDER BY nama_kelas ASC');
                                @endphp
                                @foreach ($kelas as $p)
                                    <option value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Mapel</label>
                            <select class="form-control custom-select" id="kode_mapel">
                                @php
                                    $mapel = DB::select('SELECT * FROM mapel  ORDER BY nama_mapel ASC');
                                @endphp
                                @foreach ($mapel as $p)
                                    <option value="{{ $p->kode_mapel }}">{{ $p->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-5">
            <div class="section-title">Data Siswa</div>
            <div class="card" id="showAbsensiMapel">

            </div>
        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showAbsensiMapel();

            function showAbsensiMapel() {

                var tanggal = $('#tanggal').val();
                var kode_kelas = $('#kode_kelas').val();
                var kode_mapel = $('#kode_mapel').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showAbsensiMapel') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        kode_kelas: kode_kelas,
                        kode_mapel: kode_mapel,
                    },
                    success: function(data) {
                        $('#showAbsensiMapel').html(data);
                    },
                });
            }

            $('#tanggal,#kode_kelas,#kode_mapel').change(function() {
                showAbsensiMapel();
            });
        });
    </script>
@endsection
