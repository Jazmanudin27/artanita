@extends('frontend.template')
@section('titlepage', 'Jadwal Pelajaran')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Jadwal Pelajaran</div>
        <div class="right">

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
                                    <label class="label">Hari</label>
                                    <select class="form-control select2" name="hari" id="hari">
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jum'at</option>
                                        <option value="Sabtu">Sabtu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Kelas</label>
                                    <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                        @php
                                            $kelas = DB::select('SELECT * FROM kelas ');
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
            </div>
        </div>
        <div class="section mt-2 mb-5" id="showJadwal">

        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showJadwal();

            function showJadwal() {

                var hari = $('#hari').val();
                var kode_kelas = $('#kode_kelas').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showJadwal') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_kelas: kode_kelas,
                        hari: hari,
                    },
                    success: function(data) {
                        $('#showJadwal').html(data);
                    },
                });
            }

            $('#kode_kelas,#hari').on("input", function(e) {
                e.preventDefault();
                showJadwal();
            });
        });
    </script>

@endsection
