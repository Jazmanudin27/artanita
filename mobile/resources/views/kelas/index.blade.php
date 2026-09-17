@extends('frontend.template')
@section('titlepage', 'Data Kelas')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Kelas</div>
        <div class="right">
            <a href="{{ route('tambahKelas') }}" class="headerButton">
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
                                    <label class="label">Nama Kelas</label>
                                    <input type="seacrh" class="form-control" autocomplete="off" id="nama_kelas"
                                        placeholder="Nama Kelas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-5" id="showKelas">

        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showKelas();

            function showKelas() {

                var nama_kelas = $('#nama_kelas').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showKelas') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_kelas: nama_kelas,
                    },
                    success: function(data) {
                        $('#showKelas').html(data);
                    },
                });
            }

            $('#nama_kelas').on("input", function(e) {
                e.preventDefault();
                showKelas();
            });

        });
    </script>

@endsection
