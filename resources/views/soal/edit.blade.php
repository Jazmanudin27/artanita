@extends('layouts.template')
@section('titlepage', 'Form Edit Soal')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Edit Soal</h1>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateSoal') }}" method="POST" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <textarea name="pertanyaan" id="pertanyaan">{!! $soal->pertanyaan !!}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="hidden" class="form-control" value="{{ $soal->id_soal }}"
                                            autocomplete="off" name="id_soal" placeholder="ID Soal" required>
                                        <input type="text" class="form-control" value="{{ $soal->jawaban_a }}"
                                            autocomplete="off" name="jawaban_a" placeholder="Jawaban a." required>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="{{ $soal->jawaban_b }}"
                                            autocomplete="off" name="jawaban_b" placeholder="Jawaban b." required>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="{{ $soal->jawaban_c }}"
                                            autocomplete="off" name="jawaban_c" placeholder="Jawaban c." required>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="{{ $soal->jawaban_d }}"
                                            autocomplete="off" name="jawaban_d" placeholder="Jawaban d." required>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="{{ $soal->jawaban_benar }}"
                                            autocomplete="off" name="jawaban_benar" placeholder="Jawaban Benar" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="kategori" required>
                                            <option {{ $soal->kategori == '1' ? 'selected' : '' }} value="1">Soal 1
                                            </option>
                                            <option {{ $soal->kategori == '2' ? 'selected' : '' }} value="2">Soal 2
                                            </option>
                                            <option {{ $soal->kategori == '3' ? 'selected' : '' }} value="3">Soal 3
                                            </option>
                                            <option {{ $soal->kategori == '4' ? 'selected' : '' }} value="4">Soal 4
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit"class="btn btn-sm btn-primary btn-block">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#pertanyaan'))
                .then(editor => {
                    console.log('CKEditor berhasil diinisialisasi:', editor);
                })
                .catch(error => {
                    console.error('Ada kesalahan saat menginisialisasi CKEditor:', error);
                });

        });
    </script>
@endsection
