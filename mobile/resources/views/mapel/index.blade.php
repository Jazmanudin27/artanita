@extends('frontend.template')
@section('titlepage', 'Data Mapel')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Mapel</div>
        <div class="right">
            <a href="{{ route('tambahMapel') }}" class="headerButton">
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
                                    <label class="label">Nama Mapel</label>
                                    <input type="seacrh" class="form-control" autocomplete="off" id="nama_mapel"
                                        placeholder="Nama Mapel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-5" id="showMapel">

        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showMapel();

            function showMapel() {

                var nama_mapel = $('#nama_mapel').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showMapel') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_mapel: nama_mapel,
                    },
                    success: function(data) {
                        $('#showMapel').html(data);
                    },
                });
            }

            $('#nama_mapel').on("input", function(e) {
                e.preventDefault();
                showMapel();
            });

        });
    </script>

@endsection
