@extends('layouts.template')
@section('titlepage', 'Data Soal')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Soal</h1>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div class="card">
                        <form action="{{ route('storeSoal') }}" method="POST" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" autocomplete="off" name="jawaban_benar"
                                            placeholder="Jawaban Benar" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control select2" name="kategori" id="kategori" required>
                                            <option value="1">Soal 1</option>
                                            <option value="2">Soal 2</option>
                                            <option value="3">Soal 3</option>
                                            <option value="4">Soal 4</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="submit"class="btn btn-sm btn-primary btn-block">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card-body" style="zoom:85%">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jawaban Benar</th>
                                        <th>Kategori</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showSoal">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
        <script>
            $(document).ready(function() {
                showSoal();

                function showSoal() {

                    var kategori = $('#kategori').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('showSoal') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            kategori: kategori,
                        },
                        success: function(data) {
                            $('#showSoal').html(data);
                        },
                    });
                }

                $('#kategori').on("change", function(e) {
                    e.preventDefault();
                    showSoal();
                });

                // $('#simpanSoal').on("click", function(e) {
                //     e.preventDefault();
                //     var pertanyaan = $('#jawaban_a').html();
                //     var jawaban_a = $('#jawaban_a').val();
                //     var jawaban_b = $('#jawaban_b').val();
                //     var jawaban_c = $('#jawaban_c').val();
                //     var jawaban_d = $('#jawaban_d').val();
                //     var jawaban_benar = $('#jawaban_benar').val();
                //     var kategori = $('#kategori').val();

                //     $.ajax({
                //         type: 'POST',
                //         url: '{{ route('storeSoal') }}',
                //         data: {
                //             _token: "{{ csrf_token() }}",
                //             pertanyaan: pertanyaan,
                //             jawaban_a: jawaban_a,
                //             jawaban_b: jawaban_b,
                //             jawaban_c: jawaban_c,
                //             jawaban_d: jawaban_d,
                //             jawaban_benar: jawaban_benar,
                //             kategori: kategori,
                //         },
                //         success: function() {
                //             showSoal();
                //         },
                //     });
                // });

            });
        </script>

    @endsection
