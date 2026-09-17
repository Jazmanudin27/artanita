<!DOCTYPE html>
<html lang="en">
@php
    $member = DB::table('member')
        ->where('member.kode_member', Auth::user()->kode_member)
        ->first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <title>Soal Psikotes</title>


    <link href="{{ asset('adminkit/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('adminkit/js/jquery.min.js') }}"></script>

    <link href="{{ asset('adminkit/css/jquery-ui.css') }}" rel="stylesheet">

    <script src="{{ asset('adminkit/js/jquery-ui.js') }}"></script>

    <script src="{{ asset('adminkit/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('adminkit/js/bootstrap.min.js') }}"></script>

    <style>
        .table-reponsive {
            width: 100%;
            overflow-x: auto;
        }

        .uang {
            text-align: right;
        }

        .select2-container {}
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                @if (session('success'))
                    <script>
                        Swal.fire(
                            'Success',
                            '{{ session('success') }}',
                            'success'
                        )
                    </script>
                @endif
                @if (session('warning'))
                    <script>
                        Swal.fire(
                            'Opps,',
                            '{{ session('warning') }}',
                            'warning'
                        )
                    </script>
                @endif
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">SOAL PSIKOTES</h1>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">

                            <div class="card">
                                <div class="card-body" style="zoom:90%">
                                    <div class="col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="nama_lengkap"
                                            placeholder="Nama Lengkap" required>
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="pendidikan"
                                            placeholder="Pendidikan Terakhhir" required>
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="jurusan" placeholder="Jurusan"
                                            required>
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <input type="text" class="form-control" id="no_hp" placeholder="No HP"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body" style="zoom:90%">
                                    <div class="col-sm-12">
                                        <a href="#" class="btn btn-success btn-block" id="startTimer">START
                                            WAKTU</a>
                                    </div>
                                    <br>
                                    <div class="col-sm-12">
                                        <a href="#" class="btn btn-primary btn-block" id="timerDisplay">30:00</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-10">
                            <div class="card">
                                <div class="col-sm-12">
                                    <div class="card-body" style="zoom:105%">
                                        <div class="table-reponsive">
                                            <table class="table table-striped" style="width:100%">
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($soal as $s)
                                                    <thead>
                                                        <tr>
                                                            <th>{{ $loop->iteration  }}. </th>
                                                            <th>
                                                                <input type="radio" name="jawaban{{ $s->id_soal }}"
                                                                    value="A" data-id="{{ $s->id_soal }}"
                                                                    class="jawaban">
                                                                A
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="jawaban{{ $s->id_soal }}"
                                                                    value="B" data-id="{{ $s->id_soal }}"
                                                                    class="jawaban">
                                                                B
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="jawaban{{ $s->id_soal }}"
                                                                    value="C" data-id="{{ $s->id_soal }}"
                                                                    class="jawaban">
                                                                C
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="jawaban{{ $s->id_soal }}"
                                                                    value="D" data-id="{{ $s->id_soal }}"
                                                                    class="jawaban">
                                                                D
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card-body" style="zoom:90%">
                                        <a href="#" class="btn btn-primary btn-block soal">Next</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            var timer;
            var timeLeft = 1800;

            function startTimer() {
                timer = setInterval(function() {
                    var minutes = Math.floor(timeLeft / 60);
                    var seconds = timeLeft % 60;

                    if (seconds < 10) {
                        seconds = "0" + seconds;
                    }

                    $("#timerDisplay").text(minutes + ":" + seconds);
                    timeLeft--;

                    if (timeLeft < 0) {
                        clearInterval(timer);
                        alert("Waktu telah habis!");
                    }
                }, 1000);
            }

            function handleStartTimer() {
                var nama_lengkap = $('#nama_lengkap').val();
                var jurusan = $('#jurusan').val();
                var pendidikan = $('#pendidikan').val();
                var no_hp = $('#no_hp').val();

                if (nama_lengkap == '') {
                    alert('Nama Lengkap Tidak Boleh Kosong')
                } else if (jurusan == '') {
                    alert('Jurusan Tidak Boleh Kosong')
                } else if (pendidikan == '') {
                    alert('Pendidikan Tidak Boleh Kosong')
                } else if (no_hp == '') {
                    alert('No HP Tidak Boleh Kosong')
                } else {
                    if (!$(this).hasClass('disabled')) {
                        startTimer();
                        $(this).addClass('disabled');
                        $('.soal').addClass('disabled');
                        $(window).on('beforeunload', function() {
                            return false;
                        });


                    }
                }

            }

            $("#startTimer").click(handleStartTimer);


            $('.jawaban').on("change", function(e) {
                e.preventDefault();
                var nama_lengkap = $('#nama_lengkap').val();
                if (nama_lengkap == '') {
                    alert('Isi Data Terlebih Dahulu Kembudian Start Waktu')
                } else {
                    var id_soal = $(this).attr('data-id');
                    var jawaban = $(this).val();
                    var nama_lengkap = $('#nama_lengkap').val();
                    var jurusan = $('#jurusan').val();
                    var pendidikan = $('#pendidikan').val();
                    var no_hp = $('#no_hp').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('updateJawaban') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_soal: id_soal,
                            jawaban: jawaban,
                            nama_lengkap: nama_lengkap,
                            jurusan: jurusan,
                            pendidikan: pendidikan,
                            no_hp: no_hp,
                        },
                        success: function() {},
                    });
                }

            });
        });
    </script>

</body>

</html>
