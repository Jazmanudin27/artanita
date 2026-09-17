@extends('frontend.template')
@section('titlepage', 'Data Guru')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Guru</div>
        <div class="right">
            <a href="{{ route('tambahGuru') }}" class="headerButton">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama Guru</label>
                                    <input type="seacrh" class="form-control" autocomplete="off" id="nama_guru"
                                        placeholder="Nama Guru">
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
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-5" id="showGuru">

        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showGuru();

            function showGuru() {

                var nama_guru = $('#nama_guru').val();
                var status = $('#status').val();
                var jk = $('#jk').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showGuru') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_guru: nama_guru,
                        status: status,
                        jk: jk,
                    },
                    success: function(data) {
                        $('#showGuru').html(data);
                    },
                });
            }

            $('#jk,#status').on("change", function(e) {
                e.preventDefault();
                showGuru();
            });

            $('#nama_guru').on("input", function(e) {
                e.preventDefault();
                showGuru();
            });

        });
    </script>

@endsection
