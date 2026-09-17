@extends('layouts.template')
@section('titlepage', 'Jadwal Pelajaran')
@section('content')
    <style>
        #map {
            height: 350px;
        }

        th {
            text-align: center;
        }
    </style>
    <div class="container-fluid p-0" style="zoom:85%">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 style="text-align: center">JADWAL PELAJARAN</h4>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <select style="color:black" class="form-control" name="hari" id="hari">
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="table-reponsive" id="showJadwal">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            showJadwal();

            function showJadwal() {
                var hari = $('#hari').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('showJadwal') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        hari: hari,
                    },
                    success: function(data) {
                        $('#showJadwal').html(data);
                    },
                });
            }

            $('#hari').on("change", function(e) {
                e.preventDefault();
                showJadwal();
            });
        });
    </script>
@endsection
