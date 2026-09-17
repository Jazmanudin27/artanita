@extends('layouts.template')
@section('titlepage', 'Data Surat Teguran')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Surat Teguran</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahSuratTeguran') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="bulan" id="bulan" class="form-control select2">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option
                                                    {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                                    value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="tahun" id="tahun" class="form-control select2">
                                            @php
                                                $startYear = date('Y') - 1;
                                                $endYear = date('Y') + 4;
                                            @endphp

                                            @for ($year = $startYear; $year <= $endYear; $year++)
                                                <option {{ Date('Y') == $year ? 'selected' : '' }}
                                                    value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="seacrh" class="form-control" autocomplete="off" id="nama_siswa"
                                            placeholder="Nama Siswa">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showSuratTeguran">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            showSuratTeguran();

            function showSuratTeguran() {

                var nama_siswa = $('#nama_siswa').val();
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showSuratTeguran') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_siswa: nama_siswa,
                        bulan: bulan,
                        tahun: tahun,
                    },
                    success: function(data) {
                        $('#showSuratTeguran').html(data);
                    },
                });
            }

            $('#bulan,#tahun').on("change", function(e) {
                e.preventDefault();
                showSuratTeguran();
            });

            $('#nama_siswa').on("input", function(e) {
                e.preventDefault();
                showSuratTeguran();
            });

        });
    </script>

@endsection
